<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUpsertRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller {
    // INDEX utente admin
    public function index(): View {
        $projects = Project::all();

        return view("admin.projects.index", compact("projects"));
    }

    // CREATE
    public function create(): View {

        $types = Type::all();
        $technologies = Technology::all();

        return view("admin.projects.create", compact("types", "technologies"));
    }

    // STORE
    public function store(ProjectUpsertRequest $request): RedirectResponse {
        // modificata in validated a seguito della creazione dello store request
        // ho già i dati validati, non serve validarli di nuovo
        $data = $request->validated();

        // invoco la funzione generateSlug passando il titolo come argomento per generare lo slug
        // aggiungo lo stesso blocco di codice nella function update
        $data["slug"] = $this->generateSlug($data["title"]);

        // salvo il file nel filesystem
        $data["image"] = Storage::put("projects", $data["image"]);

        // fill e save
        $project = Project::create($data);

        // nello store invece uso l'attach in quanto sto immagazzinando da zero dei dati,
        // è inutile fare il sync in questo caso
        // per forza dopo il create/save perchè prima non ci sono i dati da aggiungere al db
        // con questo if do la disponibilità all'utente di aggiungere un progetto senza technologies
        if (key_exists("technologies", $data)) {
            $project->technologies()->attach($data["technologies"]);
        }
        
        return redirect()->route("admin.projects.show", $project->slug);
    }

    // SHOW
    public function show(string $slug): View {
        // con first, recupero il primo elemento slug 
        $project = Project::where("slug", $slug)->first();

        return view("admin.projects.show", compact("project"));
    }

    // EDIT
    public function edit(string $slug): View  {

        $project = Project::where("slug", $slug)->firstOrFail();
        $types = Type::all();
        $technologies = Technology::all();

        return view("admin.projects.edit", compact("project", "types", "technologies"));
    }

    // UPDATE
    public function update(ProjectUpsertRequest $request, $slug) {
        $data = $request->validated();

        // Log::debug(var_export($data, true));
        // die();

        $project = Project::where("slug", $slug)->firstOrFail();

        // a questo punto dovrei rifare il procedimento per lo slug per aggiornarlo,
        // ma non ha senso faccio prima a controllare se è cambiato o no
        // nel mio caso solo il titolo (che corrisponde allo slug)
        if ($data["title"] !== $project->title) {
            $data["slug"] = $this->generateSlug($data["title"]);
        }

        // se la checkbox è spuntata, il server riceve il valore della checkbox
        // altrimenti, il server non riceve il valore della checkbox ma inserisce null
        if (isset($data["is_published"])) {
            $project->is_published = true;
            $project->published_at = now();
            // $project->save();
        }else {
            $project->is_published = false;
            $project->published_at = null;
            // $project->save();
        }
        

        if (isset($data["image_link"])) {
            // Recupero il codice binario dell'immagine dal link
            $imgLink = file_get_contents($data["image_link"]);

            // creo un nome per il file
            $path = "projects/" . uniqid();

            // creo il file inserendo il codice binario come contenuto
            File::put(storage_path("app/public/" . $path), $imgLink);

            // salvo il path nel database
            $data["image"] = $path;
        } else if (isset($data["image"])) {

            // se esiste già un'immagine, prima la cancello
            if($project->image) {
                Storage::delete($project->image);
            }

            // prima dell'update salvo il file uploadato nel filesystem
            $image_path = Storage::put("projects", $data["image"]);
            // il path mi serve per il db
            $data["image"] = $image_path;
        }

        // prima dell'update devo fare l'assegnazione delle technologies per la tab ponte
        // con la funzione sync esegue il detach delle technologies non presenti nel nuovo array
        // poi esegue l'attach solo delle techologies presenti nel vecchio array
        $project->technologies()->sync($data["technologies"]);

        // spostando l'update dopo l'if di is published, posso evitare di inserire i due save
        $project->update($data);
        

        return redirect()->route("admin.projects.show", $project->slug);
    }

    protected function generateSlug($title){
        // uso un contatore per avere un numero incrementale nel caso ho lo stesso titolo
        $counter = 0;

        do{
            // creo uno slug e se il counter è > 0, concateno il counter con l'incremento
            $slug = Str::slug($title) . ($counter > 0 ? "-" . $counter : "");

            // creo una variabile da utilizzare per capire se esiste già un elemento con questo slug
            $alreadyExists = Project::where("slug", $slug)->first(); // first coerente col do while
            
            // assegno l'incremento al contatore
            $counter++;
        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        return $slug;
    }

    public function destroy($slug) {
        $project = Project::where("slug", $slug)->firstOrFail();
        $project->delete();
        return redirect()->route("admin.projects.index");
    }
}
