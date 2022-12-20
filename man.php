<?php
// Start Initialize: -----------------------------------------------
// EX:  Cat, Product are module
$m_name_p = $_POST['m_name_p']; // $m_name_p : module name pruler
$m_name_s = $_POST['m_name_s']; // $m_name_p : module name singular

$m_b_name_p = ucfirst($m_name_p); // $m_b_name_p: module name pruler big first latter  
$m_b_name_s = ucfirst($m_name_s); // $m_b_name_s: module name singular big first latter 

// End Initialize: -------------------------------------------------

// Start (Events) --------------------------------------------------------

// 1- [module]Create.php --
if (!file_exists("app\Events\Backend\\" . $m_b_name_p)) {
    mkdir("app\Events\Backend\\" . $m_b_name_p, 0777, true);
}

$myfile = fopen("app\Events\Backend\\" . $m_b_name_p . "\\" . $m_b_name_s . "Created.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Events\Backend\\" . $m_b_name_p . ";

use Illuminate\Queue\SerializesModels;

/**
 * Class " . $m_b_name_s . "Created.
 */
class " . $m_b_name_s . "Created
{
    use SerializesModels;

    /**
     * @var
     */
    public $" . $m_name_s . ";

    /**
     * @param $" . $m_name_s . "
     */
    public function __construct($" . $m_name_s . ")
    {
        \$this->" . $m_name_s . " = $" . $m_name_s . ";
    }
}
";

fwrite($myfile, $txt);
fclose($myfile);

// 2- [module]Deleted.php --
$myfile = fopen("app\Events\Backend\\" . $m_b_name_p . "\\" . $m_b_name_s . "Deleted.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Events\Backend\\" . $m_b_name_p . ";

use Illuminate\Queue\SerializesModels;

/**
 * Class " . $m_b_name_p . "Deleted.
 */
class " . $m_b_name_s . "Deleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $" . $m_name_s . ";

    /**
     * @param $" . $m_name_s . "
     */
    public function __construct($" . $m_name_s . ")
    {
        \$this->" . $m_name_s . " = $" . $m_name_s . ";
    }
}
";

fwrite($myfile, $txt);
fclose($myfile);

// 3- [module]Update.php --
$myfile = fopen("app\Events\Backend\\" . $m_b_name_p . "\\" . $m_b_name_s . "Updated.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Events\Backend\\" . $m_b_name_p . ";

use Illuminate\Queue\SerializesModels;

/**
 * Class " . $m_b_name_s . "Updated.
 */
class " . $m_b_name_s . "Updated
{
    use SerializesModels;

    /**
     * @var
     */
    public $" . $m_name_s . ";

    /**
     * @param $" . $m_name_s . "
     */
    public function __construct($" . $m_name_s . ")
    {
        \$this->" . $m_name_s . " = $" . $m_name_s . ";
    }
}
";

fwrite($myfile, $txt);
fclose($myfile);
// End (Events)----------------------------------------------------------------------

// Start (Controllers) --------------------------------------------------------

// 4- [module]Controller.php --
if (!file_exists("app\Http\Controllers\Backend\\" . $m_b_name_p)) {
    mkdir("app\Http\Controllers\Backend\\" . $m_b_name_p, 0777, true);
}

$myfile = fopen("app\Http\Controllers\Backend\\" . $m_b_name_p . "\\" . $m_b_name_p . "Controller.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Http\Controllers\Backend\\" . $m_b_name_p . ";

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Create" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Delete" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Edit" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Manage" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Store" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Update" . $m_b_name_s . "Request;
use App\Http\Responses\Backend\\" . $m_b_name_s . "\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\\" . $m_b_name_s . ";
use App\Repositories\Backend\\" . $m_b_name_p . "Repository;
use Illuminate\Support\Facades\View;

class " . $m_b_name_s . "sController extends Controller
{
    /**
     * @var \App\Repositories\Backend\\" . $m_b_name_p . "Repository
     */
    protected \$repository;

    /**
     * @param \App\Repositories\Backend\\" . $m_b_name_p . "Repository \$repository
     */
    public function __construct(" . $m_b_name_s . "sRepository \$repository)
    {
        \$this->repository = \$repository;
        View::share('js', ['" . $m_name_s . "s']);
    }

    /**
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Manage" . $m_b_name_s . "Request \$request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(Manage" . $m_b_name_s . "Request \$request)
    {
        return new ViewResponse('backend." . $m_name_s . "s.index');
    }

    /**
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Create" . $m_b_name_s . "Request \$request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(Create" . $m_b_name_s . "Request \$request)
    {
        return new ViewResponse('backend." . $m_name_s . "s.create');
    }

    /**
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Store" . $m_b_name_s . "Request \$request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(Store" . $m_b_name_s . "Request \$request)
    {
        \$this->repository->create(\$request->except(['_token', '_method']));

        return new RedirectResponse(route('admin." . $m_name_s . "s.index'), ['flash_success' => __('alerts.backend.pages.created')]);
    }

    /**
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Edit" . $m_b_name_s . "Request \$request
     *
     * @return \App\Http\Responses\Backend\Blog\EditResponse
     */
    public function edit(" . $m_b_name_s . " $" . $m_name_s . ", Edit" . $m_b_name_s . "Request \$request)
    {
        return new EditResponse($" . $m_name_s . ");
    }

    /**
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Update" . $m_b_name_s . "Request \$request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(" . $m_b_name_s . " $" . $m_name_s . ", Update" . $m_b_name_s . "Request \$request)
    {
        \$this->repository->update($" . $m_name_s . ", \$request->except(['_token', '_method']));

        return new RedirectResponse(route('admin." . $m_name_s . "s.index'), ['flash_success' => __('alerts.backend.pages.updated')]);
    }

    /**
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Delete" . $m_b_name_s . "Request \$request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(" . $m_b_name_s . " $" . $m_name_s . ", Delete" . $m_b_name_s . "Request \$request)
    {
        \$this->repository->delete($" . $m_name_s . ");

        return new RedirectResponse(route('admin." . $m_name_s . "s.index'), ['flash_success' => __('alerts.backend.pages.deleted')]);
    }
}

";

fwrite($myfile, $txt);
fclose($myfile);

// 5- [module]TableController.php --
$myfile = fopen("app\Http\Controllers\Backend\\" . $m_b_name_p . "\\" . $m_b_name_p . "TableController.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Http\Controllers\Backend\\" . $m_b_name_p . ";

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Manage" . $m_b_name_s . "Request;
use App\Repositories\Backend\\" . $m_b_name_p . "Repository;
use Yajra\DataTables\Facades\DataTables;

class " . $m_b_name_s . "sTableController extends Controller
{
    /**
     * @var \App\Repositories\Backend\\" . $m_b_name_p . "Repository
     */
    protected \$repository;

    /**
     * @param \App\Repositories\Backend\\" . $m_b_name_p . "Repository \$repository
     */
    public function __construct(" . $m_b_name_s . "sRepository \$repository)
    {
        \$this->repository = \$repository;
    }

    /**
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Manage\\" . $m_b_name_s . "Request \$request
     *
     * @return mixed
     */
    public function __invoke(Manage" . $m_b_name_s . "Request \$request)
    {
        return Datatables::of(\$this->repository->getForDataTable())
            ->editColumn('created_at', function (\$" . $m_name_s . ") {
                return \$" . $m_name_s . "->created_at->toDateString();
            })
            ->addColumn('actions', function (\$" . $m_name_s . ") {
                return \$" . $m_name_s . "->action_buttons;
            })
            ->escapeColumns(['title'])
            ->make(true);
    }
}
";

fwrite($myfile, $txt);
fclose($myfile);
// End (Controllers)---------------------------------------------------------------------

// Start (Requests)---------------------------------------------------------------------
// 6- Create[module]Request.php --
if (!file_exists("app\Http\Requests\Backend\\" . $m_b_name_p)) {
    mkdir("app\Http\Requests\Backend\\" . $m_b_name_p, 0777, true);
}

$reqs = ["Create", "Delete", "Edit", "Manage", "Store", "Update"];

foreach ($reqs as $req) {
    $myfile = fopen("app\Http\Requests\Backend\\" . $m_b_name_p . "\\" . $req . $m_b_name_s . "Request.php", "w") or die("Unable to open file!");

    $txt = "<?php
    namespace App\Http\Requests\Backend\\" . $m_b_name_p . ";
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class " . $req . $m_b_name_s . "Request extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return access()->allow('edit-page');
        }
    
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                // 'cannonical_link' => ['string', 'nullable', 'url'],
                // 'seo_title' => ['string', 'nullable'],
                // 'seo_keyword' => ['string', 'nullable'],
                // 'seo_description' => ['string', 'nullable'],
            ];
        }
    }
    ";

    fwrite($myfile, $txt);
    fclose($myfile);
}

// Start (Resources)---------------------------------------------------------------------
// 7- [module]Resource.php --
if (!file_exists("app\Http\Resources")) {
    mkdir("app\Http\Resources", 0777, true);
}

$myfile = fopen("app\Http\Resources\\" . $m_b_name_p . "Resource.php", "w") or die("Unable to open file!");

$inner = "'" . $_POST['property_name'][0] . "'" . "=>\$this->" . $_POST['property_name'][0];

for ($i = 1; $i < count($_POST['property_name']); $i++) {
    $inner .= ",\n\t\t\t\t'" . $_POST['property_name'][$i] . "'" . "=>\$this->" . $_POST['property_name'][$i];
}

$txt = "<?php

    namespace App\Http\Resources;
    
    use Illuminate\Http\Resources\Json\Resource;
    
    class " . $m_b_name_p . "Resource extends Resource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request
         *
         * @return array
         */
        public function toArray(\$request)
        {
            return [
                " . $inner . "
            ];
        }
    }
    
    ";

fwrite($myfile, $txt);
fclose($myfile);

// API Controller:
if (!file_exists("app\Http\Controllers\Api\V1\\")) {
    mkdir("app\Http\Controllers\Api\V1\\", 0777, true);
}

$myfile = fopen("app\Http\Controllers\Api\V1\\" . $m_b_name_p . "Controller.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\\" . $m_b_name_p . "\Delete" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Manage" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Store" . $m_b_name_s . "Request;
use App\Http\Requests\Backend\\" . $m_b_name_p . "\Update" . $m_b_name_s . "Request;
use App\Http\Resources\\" . $m_b_name_p . "Resource;
use App\Models\\" . $m_b_name_s . ";
use App\Repositories\Backend\\" . $m_b_name_p . "Repository;
use Illuminate\Http\Response;

/**
 * @group " . $m_b_name_p . " Management
 *
 * Class " . $m_b_name_p . "Controller
 *
 * APIs for " . $m_b_name_p . " Management
 *
 * @authenticated
 */
class " . $m_b_name_p . "Controller extends APIController
{
    /**
     * Repository.
     *
     * @var " . $m_b_name_p . "Repository
     */
    protected \$repository;

    /**
     * __construct.
     *
     * @param \$repository
     */
    public function __construct(" . $m_b_name_p . "Repository \$repository)
    {
        \$this->repository = \$repository;
    }

    /**
     * Get all " . $m_b_name_p . ".
     *
     * This endpoint provides a paginated list of all " . $m_name_s . "s. You can customize how many records you want in each
     * returned response as well as sort records based on a key in specific order.
     *
     * @queryParam " . $m_name_s . " Which " . $m_name_s . " to show. Example: 12
     * @queryParam per_" . $m_name_s . " Number of records per " . $m_name_s . ". (use -1 to retrieve all) Example: 20
     * @queryParam order_by Order by database column. Example: created_at
     * @queryParam order Order direction ascending (asc) or descending (desc). Example: asc
     *
     * @responseFile status=401 scenario=\"api_key not provided\" responses/unauthenticated.json
     * @responseFile responses/" . $m_name_s . "/" . $m_name_s . "-list.json
     *
     * @param \Illuminate\Http\Manage" . $m_b_name_s . "Request \$request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Manage" . $m_b_name_s . "Request \$request)
    {
        \$collection = \$this->repository->retrieveList(\$request->all());

        return " . $m_b_name_p . "Resource::collection(\$collection);
    }

    /**
     * Gives a specific " . $m_b_name_s . ".
     *
     * This endpoint provides you a single " . $m_b_name_s . "
     * The " . $m_b_name_s . " is identified based on the ID provided as url parameter.
     *
     * @urlParam id required The ID of the " . $m_b_name_s . "
     *
     * @responseFile status=401 scenario=\"api_key not provided\" responses/unauthenticated.json
     * @responseFile responses/" . $m_name_s . "/" . $m_name_s . "-show.json
     *
     * @param Manage" . $m_b_name_s . "Request \$request
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Manage" . $m_b_name_s . "Request \$request, " . $m_b_name_s . " $" . $m_name_s . ")
    {
        return new " . $m_b_name_p . "Resource($" . $m_name_s . ");
    }

    /**
     * Create a new " . $m_b_name_s . ".
     *
     * This endpoint lets you create new " . $m_b_name_s . "
     *
     * @responseFile status=401 scenario=\"api_key not provided\" responses/unauthenticated.json
     * @responseFile status=201 responses/" . $m_name_s . "/" . $m_name_s . "-store.json
     *
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Store" . $m_b_name_s . "Request \$request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Store" . $m_b_name_s . "Request \$request)
    {
        $" . $m_name_s . " = \$this->repository->create(\$request->validated());

        return (new " . $m_b_name_p . "Resource($" . $m_name_s . "))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update " . $m_b_name_s . ".
     *
     * This endpoint allows you to update existing " . $m_b_name_s . " with new data.
     * The " . $m_b_name_s . " to be updated is identified based on the ID provided as url parameter.
     *
     * @urlParam id required The ID of the " . $m_b_name_s . "
     *
     * @responseFile status=401 scenario=\"api_key not provided\" responses/unauthenticated.json
     * @responseFile responses/" . $m_name_s . "/" . $m_name_s . "-update.json
     *
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     * @param \App\Http\Requests\Backend\\" . $m_b_name_p . "\Update" . $m_b_name_s . "Request \$request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Update" . $m_b_name_s . "Request \$request, " . $m_b_name_s . " $" . $m_name_s . ")
    {
        $" . $m_name_s . " = \$this->repository->update($" . $m_name_s . ", \$request->validated());

        return new " . $m_b_name_p . "Resource($" . $m_name_s . ");
    }

    /**
     * Delete " . $m_b_name_s . ".
     *
     * This endpoint allows you to delete a " . $m_b_name_s . "
     * The " . $m_b_name_s . " to be deleted is identified based on the ID provided as url parameter.
     *
     * @urlParam id required The ID of the " . $m_b_name_s . "
     *
     * @responseFile status=401 scenario=\"api_key not provided\" responses/unauthenticated.json
     * @responseFile status=204 scenario=\"When the record is deleted\" responses/" . $m_name_s . "/" . $m_name_s . "-destroy.json
     *
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Delete" . $m_b_name_s . "Request \$request, " . $m_b_name_s . " $" . $m_name_s . ")
    {
        \$this->repository->delete($" . $m_name_s . ");

        return response()->noContent();
    }
}
";

fwrite($myfile, $txt);
fclose($myfile);

// End (Resource)---------------------------------------------------------------------

// Start (Responses)---------------------------------------------------------------------
// 7- Responses.php --
if (!file_exists("app\Http\Responses\Backend\\" . $m_b_name_s)) {
    mkdir("app\Http\Responses\Backend\\" . $m_b_name_s, 0777, true);
}

$myfile = fopen("app\Http\Responses\Backend\\" . $m_b_name_s . "\EditResponse.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Http\Responses\Backend\\" . $m_b_name_s . ";

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var \App\Models\\" . $m_b_name_s . "\\" . $m_b_name_s . "
     */
    protected $" . $m_name_s . ";

    /**
     * @param \App\Models\\" . $m_b_name_s . "\\" . $m_b_name_s . " " . $m_name_s . "
     */
    public function __construct($" . $m_name_s . ")
    {
        \$this->" . $m_name_s . " = $" . $m_name_s . ";
    }

    /**
     * toReponse.
     *
     * @param \Illuminate\Http\Request \$request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse(\$request)
    {
        return view('backend." . $m_name_s . "s.edit')
            ->with" . $m_b_name_s . "(\$this->" . $m_name_s . ");
    }
}

    ";

fwrite($myfile, $txt);
fclose($myfile);

// End (Responses)---------------------------------------------------------------------

// Start (Models)---------------------------------------------------------------------
// 7- [Module].php --
if (!file_exists("app\Models")) {
    mkdir("app\Models", 0777, true);
}

$inner = "'" . $_POST['property_name'][0] . "'";

for ($i = 1; $i < count($_POST['property_name']); $i++) {
    $inner .= ",\n\t\t'" . $_POST['property_name'][$i] . "'";
}

$myfile = fopen("app\Models\\" . $m_name_s . ".php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Models;

use App\Models\Traits\Attributes\\" . $m_b_name_s . "Attributes;
use App\Models\Traits\ModelAttributes;
use App\Models\Traits\Relationships\\" . $m_b_name_s . "Relationships;

class " . $m_b_name_s . " extends BaseModel
{
    use  ModelAttributes, " . $m_b_name_s . "Relationships, " . $m_b_name_s . "Attributes;

    /**
     * The guarded field which are not mass assignable.
     *
     * @var array
     */
    protected \$guarded = ['id'];

    /**
     * Fillable.
     *
     * @var array
     */
    protected \$fillable = [
        " . $inner . "
    ];
}
    ";

fwrite($myfile, $txt);
fclose($myfile);

// End (Models)---------------------------------------------------------------------

// Start (Traits)---------------------------------------------------------------------
// 7- [Module].php --
if (!file_exists("app\Models\Traits\Attributes")) {
    mkdir("app\Models\Traits\Attributes", 0777, true);
}

$myfile = fopen("app\Models\Traits\Attributes\\" . $m_b_name_s . "Attributes.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Models\Traits\Attributes;

trait " . $m_b_name_s . "Attributes
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class=\"btn-group action-btn\">
                    '.\$this->getEditButtonAttribute('edit-page', 'admin." . $m_name_s . "s.edit').'                    
                    '.\$this->getDeleteButtonAttribute('delete-page', 'admin." . $m_name_s . "s.destroy').'
                </div>';
    }

    /**
     * @return string
     */
    public function getViewButtonAttribute()
    {
        return '<a target=\"_blank\" href=\"'.route('frontend." . $m_name_s . "s.show', \$this->page_slug).'\" class=\"btn btn-flat btn-default\">
                    <i data-toggle=\"tooltip\" data-placement=\"top\" title=\"View Page\" class=\"fa fa-eye\"></i>
                </a>';
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if (\$this->isActive()) {
            return \"<label class='label label-success'>\".trans('labels.general.active').'</label>';
        }

        return \"<label class='label label-danger'>\".trans('labels.general.inactive').'</label>';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return \$this->status == 1;
    }

    /**
     * Get Display Status Attribute.
     *
     * @var string
     */
    public function getDisplayStatusAttribute(): string
    {
        return \$this->isActive() ? 'Active' : 'InActive';
    }
}
    ";

fwrite($myfile, $txt);
fclose($myfile);

// End (Traits)---------------------------------------------------------------------

// Start (Relationships)---------------------------------------------------------------------
// 7- [Module]Relationships.php --
if (!file_exists("app\Models\Traits\Relationships")) {
    mkdir("app\Models\Traits\Relationships", 0777, true);
}

$myfile = fopen("app\Models\Traits\Relationships\\" . $m_b_name_s . "Relationships.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Models\Traits\Relationships;

use App\Models\Auth\User;

trait " . $m_b_name_s . "Relationships
{

}
    ";

fwrite($myfile, $txt);
fclose($myfile);

// End (Relationships)---------------------------------------------------------------------


// Start (Models)---------------------------------------------------------------------
// 7- [Module].php --
if (!file_exists("app\Repositories\Backend")) {
    mkdir("app\Repositories\Backend", 0777, true);
}

$inner = "'" . $_POST['property_name'][0] . "'";

for ($i = 1; $i < count($_POST['property_name']); $i++) {
    $inner .= ",\n\t\t'" . $_POST['property_name'][$i] . "'";
}

$myfile = fopen("app\Repositories\Backend\\" . $m_b_name_p . "Repository.php", "w") or die("Unable to open file!");

$txt = "<?php

namespace App\Repositories\Backend;

use App\Events\Backend\\" . $m_b_name_s . "s\\" . $m_b_name_s . "Created;
use App\Events\Backend\\" . $m_b_name_s . "s\\" . $m_b_name_s . "Deleted;
use App\Events\Backend\\" . $m_b_name_s . "s\\" . $m_b_name_s . "Updated;
use App\Exceptions\GeneralException;
use App\Models\\" . $m_b_name_s . ";
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;

class " . $m_b_name_s . "sRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = " . $m_b_name_s . "::class;

    /**
     * Sortable.
     *
     * @var array
     */
    private \$sortable = [
        'id',
        'created_at',
        'updated_at',
        " . $inner . "
    ];

    /**
     * Retrieve List.
     *
     * @var array
     * @return Collection
     */
    public function retrieveList(array \$options = [])
    {
        \$perPage = isset(\$options['per_page']) ? (int) \$options['per_page'] : 20;
        \$orderBy = isset(\$options['order_by']) && in_array(\$options['order_by'], \$this->sortable) ? \$options['order_by'] : 'created_at';
        \$order = isset(\$options['order']) && in_array(\$options['order'], ['asc', 'desc']) ? \$options['order'] : 'desc';
        \$query = \$this->query()
            ->with([
                'owner',
                'updater',
            ])
            ->orderBy(\$orderBy, \$order);

        if (\$perPage == -1) {
            return \$query->get();
        }

        return \$query->paginate(\$perPage);
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return \$this->query()
            ->select([
                'id',
                " . $inner . "
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * @param array \$input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array \$input)
    {

        if ($" . $m_name_s . " = " . $m_b_name_s . "::create(\$input)) {
            event(new " . $m_b_name_s . "Created($" . $m_name_s . "));

            return $" . $m_name_s . "->fresh();
        }

        throw new GeneralException(__('exceptions.backend.pages.create_error'));
    }

    /**
     * Update " . $m_b_name_s . ".
     *
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     * @param array \$input
     */
    public function update(" . $m_b_name_s . " $" . $m_name_s . ", array \$input)
    {

        if ($" . $m_name_s . "->update(\$input)) {
            event(new " . $m_b_name_s . "Updated($" . $m_name_s . "));

            return $" . $m_name_s . ";
        }

        throw new GeneralException(
            __('exceptions.backend.pages.update_error')
        );
    }

    /**
     * @param \App\Models\\" . $m_b_name_s . " $" . $m_name_s . "
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(" . $m_b_name_s . " $" . $m_name_s . ")
    {
        if ($" . $m_name_s . "->delete()) {
            event(new " . $m_b_name_s . "Deleted($" . $m_name_s . "));

            return true;
        }

        throw new GeneralException(__('exceptions.backend.pages.delete_error'));
    }
}
   ";

fwrite($myfile, $txt);
fclose($myfile);

// End (Models)---------------------------------------------------------------------

// Start (Migrations)---------------------------------------------------------------------
// 7- [Module].php --
if (!file_exists("database\migrations")) {
    mkdir("database\migrations", 0777, true);
}

$inner = "\$table->" . $_POST['property_type'][0] . "('" . $_POST['property_name'][0] . "');";

for ($i = 1; $i < count($_POST['property_name']); $i++) {
    $inner .= "\n\t\t\t\$table->" . $_POST['property_type'][$i] . "('" . $_POST['property_name'][$i] . "');";
}

$myfile = fopen("database\migrations\\" . date("Y_m_d") . "_" . $m_name_p . ".php", "w") or die("Unable to open file!");

$txt = "<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class " . $m_b_name_p . " extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('" . $m_name_p . "', function (Blueprint \$table) {
            \$table->bigIncrements('id');
            " . $inner . "
            \$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('" . $m_name_p . "');
    }
}
    ";

fwrite($myfile, $txt);
fclose($myfile);

// End (Migrations)---------------------------------------------------------------------


// Start (javascript)---------------------------------------------------------------------
// 7- [Module].js --
if (!file_exists("public\js\backend\\")) {
    mkdir("public\js\backend\\", 0777, true);
}

$inner = "{ data: '" . $_POST['property_name'][0] . "', name: '" . $_POST['property_name'][0] . "' },";

for ($i = 1; $i < count($_POST['property_name']); $i++) {
    $inner .= "\n\t\t\t\t\t{ data: '" . $_POST['property_name'][$i] . "', name: '" . $_POST['property_name'][$i] . "' },";
}

$myfile = fopen("public\js\backend\\" . $m_name_p . ".js", "w") or die("Unable to open file!");

$txt = "(function () {

    FTX." . $m_b_name_p . " = {

        list: {
        
            selectors: {
                " . $m_name_p . "_table: $('#" . $m_name_p . "-table'),
            },
        
            init: function () {

                this.selectors." . $m_name_p . "_table.dataTable({

                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: this.selectors." . $m_name_p . "_table.data('ajax_url'),
                        type: 'post',
                        data: { status: 1, trashed: false }
                    },
                    columns: [
                        " . $inner . "
                        { data: 'created_at', name: 'created_at' },
                        { data: 'actions', name: 'actions', searchable: false, sortable: false }

                    ],
                    order: [[0, \"asc\"]],
                    searchDelay: 500,
                    \"createdRow\": function (row, data, dataIndex) {
                        FTX.Utils.dtAnchorToForm(row);
                    }
                });
            }
        },

        edit: {
            init: function (locale) {
                FTX.tinyMCE.init();                
            }
        },
    }
})();    ";

fwrite($myfile, $txt);
fclose($myfile);

// End (javascript)---------------------------------------------------------------------

// Start (routes)---------------------------------------------------------------------
// 7- [Module].js --
if (!file_exists("routes\backend\\")) {
    mkdir("routes\backend\\", 0777, true);
}

$myfile = fopen("routes\backend\\" . $m_b_name_p . ".php", "w") or die("Unable to open file!");

$txt = "<?php

// " . $m_b_name_p . " Management
Route::group(['namespace' => '" . $m_b_name_p . "'], function () {
    Route::resource('" . $m_name_p . "', '" . $m_b_name_p . "Controller', ['except' => ['show']]);

    //For DataTables
    Route::post('" . $m_name_p . "/get', '" . $m_b_name_p . "TableController')->name('" . $m_name_p . ".get');
});";

fwrite($myfile, $txt);
fclose($myfile);

// -------------------------
$myfile = fopen("routes\api.php", "r") or die("Unable to open file!");
$contents = fread($myfile, filesize("routes\api.php"));
fclose($myfile);

$myfile = fopen("routes\api.php", 'w+');
$txt = "\t// Auto-Generated:  " . $m_b_name_p . "
    Route::apiResource('" . $m_name_p . "', '" . $m_b_name_p . "Controller'); \n";

$newstr = substr_replace($contents, $txt, -4, 0);
fwrite($myfile, $newstr);
fclose($myfile);

// End (routes)---------------------------------------------------------------------

// Start (breadcrumbs)---------------------------------------------------------------------
// 7- [Module].js --
if (!file_exists("routes\breadcrumbs\backend\\" . $m_name_p)) {
    mkdir("routes\breadcrumbs\backend\\" . $m_name_p, 0777, true);
}

$myfile = fopen("routes\breadcrumbs\backend\\" . $m_name_p . "\\" . $m_name_s . ".php", "w") or die("Unable to open file!");

$txt = "<?php
Breadcrumbs::for('admin." . $m_name_p . ".index', function (\$trail) {
    \$trail->push(__('labels.backend.access.pages.management'), route('admin." . $m_name_p . ".index'));
});

Breadcrumbs::for('admin." . $m_name_p . ".create', function (\$trail) {
    \$trail->parent('admin." . $m_name_p . ".index');
    \$trail->push(__('labels.backend.access.pages.management'), route('admin." . $m_name_p . ".create'));
});

Breadcrumbs::for('admin." . $m_name_p . ".edit', function (\$trail, \$id) {
    \$trail->parent('admin." . $m_name_p . ".index');
    \$trail->push(__('labels.backend.access.pages.management'), route('admin." . $m_name_p . ".edit', \$id));
});
";

fwrite($myfile, $txt);
fclose($myfile);

$myfile = fopen("routes\breadcrumbs\backend\backend.php", "a") or die("Unable to open file!");

$txt = "require __DIR__.'/" . $m_b_name_p . "/" . $m_name_s . ".php';\n";

fwrite($myfile, $txt);
fclose($myfile);
// End (breadcrumbs)---------------------------------------------------------------------

// Start (Views)---------------------------------------------------------------------
// includes: breadcrumb-links

if (!file_exists("resources\\views\backend\\" . $m_name_p."\includes")) {
    mkdir("resources\\views\backend\\" . $m_name_p."\includes", 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\includes\breadcrumb-links.blade.php", "w") or die("Unable to open file!");

$txt = "<li class=\"breadcrumb-menu\">
<div class=\"btn-group\" role=\"group\" aria-label=\"Button group\">
    <div class=\"dropdown\">
        <a class=\"btn dropdown-toggle\" href=\"#\" role=\"button\" id=\"breadcrumb-dropdown-1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">{{ __('labels.backend.access.pages.all') }}</a>

        <div class=\"dropdown-menu\" aria-labelledby=\"breadcrumb-dropdown-1\">
            <a class=\"dropdown-item\" href=\"{{ route('admin." . $m_name_p.".index') }}\">{{ trans('labels.backend.access.pages.all') }}</a>
            <a class=\"dropdown-item\" href=\"{{ route('admin." . $m_name_p.".create') }}\">{{ trans('labels.backend.access.pages.create') }}</a>
        </div>
    </div><!--dropdown-->

    <!--<a class=\"btn\" href=\"#\">Static Link</a>-->
</div><!--btn-group-->
</li>";

fwrite($myfile, $txt);
fclose($myfile);

// includes: header-buttons
if (!file_exists("resources\\views\backend\\" . $m_name_p."\includes")) {
    mkdir("resources\\views\backend\\" . $m_name_p."\includes", 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\includes\header-buttons.blade.php", "w") or die("Unable to open file!");

$txt = "<div class=\"btn-toolbar float-right\" role=\"toolbar\" aria-label=\"@lang('labels.general.toolbar_btn_groups')\">
<a href=\"{{ route('admin.pages.create') }}\" class=\"btn btn-success ml-1\" data-toggle=\"tooltip\" title=\"@lang('labels.general.create_new')\"><i class=\"fas fa-plus-circle\"></i></a>
</div><!--btn-toolbar-->
";

fwrite($myfile, $txt);
fclose($myfile);

// show\tabs
if (!file_exists("resources\\views\backend\\" . $m_name_p."\show\\tabs\\")) {
    mkdir("resources\\views\backend\\" . $m_name_p."\show\\tabs\\", 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\show\\tabs\overview.blade.php", "w") or die("Unable to open file!");

$txt = "<div class=\"col\">
<div class=\"table-responsive\">
    <table class=\"table table-hover\">
        <tr>
            <th>Logo</th>
            <td><img src=\"{{ \$company->logo }}\" class=\"user-profile-image\" /></td>
        </tr>

        <tr>
            <th>@lang('labels.backend.access.users.tabs.content.overview.name')</th>
            <td>{{ \$company->name }}</td>
        </tr>

        <tr>
            <th>@lang('labels.backend.access.users.tabs.content.overview.email')</th>
            <td>{{ \$company->email }}</td>
        </tr>

        <tr>
            <th>Website</th>
            <td>{{\$company->website}}</td>
        </tr>

        <tr>
            <th>@lang('labels.backend.access.users.tabs.content.overview.status')</th>
            <td>
                @if(\$company->isActive())
                    <span class='badge badge-success'>@lang('labels.general.active')</span>
                @else
                    <span class='badge badge-danger'>@lang('labels.general.inactive')</span>
                @endif
            </td>
        </tr>

    </table>
</div>
</div><!--table-responsive-->
";

fwrite($myfile, $txt);
fclose($myfile);

// view: create
if (!file_exists("resources\\views\backend\\" . $m_name_p)) {
    mkdir("resources\\views\backend\\" . $m_name_p, 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\create.blade.php", "w") or die("Unable to open file!");

$txt = "@extends('backend.layouts.app')

@section('title', __('labels.backend.access.pages.management') . ' | ' . __('labels.backend.access.pages.create'))

@section('breadcrumb-links')
    @include('backend." . $m_name_p.".includes.breadcrumb-links')
@endsection

@section('content')
    {{ Form::open(['route' => 'admin." . $m_name_p.".store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

    <div class=\"card\">
        @include('backend." . $m_name_p.".form')
        @include('backend.components.footer-buttons', ['cancelRoute' => 'admin." . $m_name_p.".index'])
    </div><!--card-->
    {{ Form::close() }}
@endsection
";

fwrite($myfile, $txt);
fclose($myfile);

// view: edit
if (!file_exists("resources\\views\backend\\" . $m_name_p)) {
    mkdir("resources\\views\backend\\" . $m_name_p, 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\\edit.blade.php", "w") or die("Unable to open file!");

$txt = "@extends('backend.layouts.app')

@section('title', __('labels.backend.access.pages.management') . ' | ' . __('labels.backend.access.pages.edit'))

@section('breadcrumb-links')
    @include('backend." . $m_name_p.".includes.breadcrumb-links')
@endsection

@section('content')
    {{ Form::model(\$" . $m_name_s.", ['route' => ['admin." . $m_name_p.".update', \$" . $m_name_s."], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role', 'files' => true]) }}

    <div class=\"card\">
        @include('backend." . $m_name_p.".form')
        @include('backend.components.footer-buttons', [ 'cancelRoute' => 'admin." . $m_name_p.".index', 'id' => \$" . $m_name_s."->id ])
    </div><!--card-->
    {{ Form::close() }}
@endsection
";

fwrite($myfile, $txt);
fclose($myfile);

// view: form
if (!file_exists("resources\\views\backend\\" . $m_name_p)) {
    mkdir("resources\\views\backend\\" . $m_name_p, 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\\form.blade.php", "w") or die("Unable to open file!");

$innner = "";
for ($i = 0; $i < count($_POST['property_name']); $i++) {
    if($_POST['property_type'][$i] == "string" || $_POST['property_type'][$i] == "double"
    || $_POST['property_type'][$i] == "uuid"|| $_POST['property_type'][$i] == "char"
    || $_POST['property_type'][$i] == "binary" || $_POST['property_type'][$i] == "bigInteger")
    {
        $innner .= "\n<div class=\"form-group row\">
        {{ Form::label(\"".$_POST['property_name'][$i]."\", ".$_POST['property_name'][$i].", ['class' => 'col-md-2 from-control-label required']) }}

        <div class=\"col-md-10\">
            {{ Form::text('".$_POST['property_name'][$i]."', null, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
        <!--col-->
        </div>
        <!--form-group-->\n";
    }else if($_POST['property_type'][$i] == "text"){

        $innner .= "\n<div class=\"form-group row\">
            {{ Form::label(\"".$_POST['property_name'][$i]."\", ".$_POST['property_name'][$i].", ['class' => 'col-md-2 from-control-label required']) }}

            <div class=\"col-md-10\">
                {{ Form::textarea('".$_POST['property_name'][$i]."', null, ['class' => 'form-control', 'placeholder' => '']) }}
            </div>
            <!--col-->
            </div>
            <!--form-group-->";
    }else if($_POST['property_type'][$i] == "integer"){

        $innner .= "\n<div class=\"form-group row\">
        {{ Form::label(\"".$_POST['property_name'][$i]."\", ".$_POST['property_name'][$i].", ['class' => 'col-md-2 from-control-label required']) }}

        <div class=\"col-md-10\">
            {{ Form::number('".$_POST['property_name'][$i]."', null, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
        <!--col-->
        </div>
        <!--form-group-->\n";
    }else if($_POST['property_type'][$i] == "dateTime"){
        $innner .= "\n<div class=\"form-group row\">
        {{ Form::label(\"".$_POST['property_name'][$i]."\", ".$_POST['property_name'][$i].", ['class' => 'col-md-2 from-control-label required']) }}

        <div class=\"col-md-10\">".
        "\n<input type=\"datetime\"  name=\"". $_POST['property_name'][$i]."\" value=\"{{isset($".$m_name_s.")?$".$m_name_s."->". $_POST['property_name'][$i].":''}}\" \>\n" ."
        </div>
        <!--col-->
        </div>
        <!--form-group-->\n";
    }else if($_POST['property_type'][$i] == "date"){
        $innner .= "\n<div class=\"form-group row\">
        {{ Form::label(\"".$_POST['property_name'][$i]."\", ".$_POST['property_name'][$i].", ['class' => 'col-md-2 from-control-label required']) }}

        <div class=\"col-md-10\">".
        "\n<input type=\"date\"  name=\"". $_POST['property_name'][$i]."\" value=\"{{".$m_name_s."->". $_POST['property_name'][$i]."}}\" \>\n" ."
        </div>
        <!--col-->
        </div>
        <!--form-group-->\n";
    }else if($_POST['property_type'][$i] == "boolean"){
        $innner .= "\n<div class=\"form-group row\">
        {{ Form::label(\"".$_POST['property_name'][$i]."\", ".$_POST['property_name'][$i].", ['class' => 'col-md-2 from-control-label required']) }}

        <div class=\"col-md-10\">".
        "\n<input class=\"switch-input\" type=\"checkbox\" name=\"". $m_name_p."\" value=\"1\" }}>\n" ."
        </div>
        <!--col-->
        </div>
        <!--form-group-->\n";
    }
}

$txt = "<div class=\"card-body\">
<div class=\"row\">
    <div class=\"col-sm-5\">
        <h4 class=\"card-title mb-0\">
            {{ __('labels.backend.access.pages.management') }}
            <small class=\"text-muted\">{{ (isset(\$page)) ? __('labels.backend.access.pages.edit') : __('labels.backend.access.pages.create') }}</small>
        </h4>
    </div>
    <!--col-->
</div>
<!--row-->

<hr>

<div class=\"row mt-4 mb-4\">
    <div class=\"col\">
        ".$innner."
    </div>
    <!--col-->
</div>
<!--row-->
</div>
<!--card-body-->

@section('pagescript')
<script type=\"text/javascript\">
FTX.Utils.documentReady(function() {
    FTX.Pages.edit.init(\"{{ config('locale.languages.' . app()->getLocale())[1] }}\");
});
</script>
@stop
";

fwrite($myfile, $txt);
fclose($myfile);
// End (Views)---------------------------------------------------------------------

// view: index
if (!file_exists("resources\\views\backend\\" . $m_name_p)) {
    mkdir("resources\\views\backend\\" . $m_name_p, 0777, true);
}

$myfile = fopen("resources\\views\backend\\" . $m_name_p."\index.blade.php", "w") or die("Unable to open file!");

for ($i = 1; $i < count($_POST['property_name']); $i++) {
    $inner .= "\n\t\t\t\t\t<th>".$_POST['property_name'][$i]."</th> ";
}

$txt = "@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.pages.management'))

@section('breadcrumb-links')
@include('backend." . $m_name_p.".includes.breadcrumb-links')
@endsection

@section('content')
<div class=\"card\">
    <div class=\"card-body\">
        <div class=\"row\">
            <div class=\"col-sm-5\">
                <h4 class=\"card-title mb-0\">
                    {{ __('labels.backend.access.pages.management') }} <small class=\"text-muted\">{{ __('labels.backend.access.pages.active') }}</small>
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class=\"row mt-4\">
            <div class=\"col\">
                <div class=\"table-responsive\">
                    <table id=\"" . $m_name_p."-table\" class=\"table\" data-ajax_url=\"{{ route(\"admin." . $m_name_p.".get\") }}\">
                        <thead>
                            <tr>
                                ".$inner."
                                <th>{{ trans('labels.backend.access.pages.table.createdat') }}</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->

    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection

@section('pagescript')
<script>
    FTX.Utils.documentReady(function() {
        FTX." . $m_b_name_p.".list.init();
    });
</script>
@endsection
";

fwrite($myfile, $txt);
fclose($myfile);
// finish - end -------------------------------------------------------

//  ------------------------------
echo "<h1>Lara infx admin - Magic tool V1.0<h1>";
echo "<p>You have to: </p>
<ul>
<li>php artisan migrate</li>
<li>check what needed to dispaly in table: repository file & js file</li>
<li>add module to sidebar</li>
<li>edit permissions if needed: app\Http\Requests\Backend\\". $m_b_name_p."\</li>
<li>Add relationships if needed: app\Models\Traits\Relationships\\". $m_b_name_s."Relationships.php</li>
</ul>
<p> proparites of ". $m_b_name_p."are:
";

echo "<p>29 Files were Created: </p>
<ul>
<li>app\Events\Backend\\". $m_b_name_p."\\". $m_b_name_s."Created.php</li>
<li>app\Events\Backend\\". $m_b_name_p."\\". $m_b_name_s."Deleted.php</li>
<li>app\Events\Backend\\". $m_b_name_p."\\". $m_b_name_s."Updated.php</li>
<li>=================================================================</li>
<li>app\Http\Controllers\Backend\\". $m_b_name_p."\\". $m_b_name_p."Controller.php</li>
<li>app\Http\Controllers\Backend\\". $m_b_name_p."\\". $m_b_name_p."TableController.php</li>
<li>=================================================================</li>
<li>app\Http\Requests\Backend\\". $m_b_name_p."\Create". $m_b_name_s."Request.php</li>
<li>app\Http\Requests\Backend\\". $m_b_name_p."\Delete". $m_b_name_s."Request.php</li>
<li>app\Http\Requests\Backend\\". $m_b_name_p."\Edit". $m_b_name_s."Request.php</li>
<li>app\Http\Requests\Backend\\". $m_b_name_p."\Manage". $m_b_name_s."Request.php</li>
<li>app\Http\Requests\Backend\\". $m_b_name_p."\Store". $m_b_name_s."Request.php</li>
<li>app\Http\Requests\Backend\\". $m_b_name_p."\Update". $m_b_name_s."Request.php</li>
<li>=================================================================</li>
<li>app\Http\Resources\\". $m_b_name_p."Resource.php</li>
<li>app\Http\Controllers\Api\V1\\". $m_b_name_p."Controller.php</li>
<li>=================================================================</li>
<li>app\Http\Responses\Backend\\". $m_b_name_s."\EditResponse.php</li>
<li>=================================================================</li>
<li>app\Models\\". $m_name_s.".php</li>
<li>app\Models\Traits\Attributes\\". $m_b_name_s."Attributes.php</li>
<li>app\Models\Traits\Relationships\\". $m_b_name_s."Relationships.php</li>
<li>=================================================================</li>
<li>app\Repositories\Backend\\". $m_b_name_p."Repository.php</li>
<li>=================================================================</li>
<li>public\js\backend\\". $m_name_p.".js</li>
<li>=================================================================</li>
<li>public\js\backend\\". $m_name_p.".js</li>
<li>=================================================================</li>
<li>routes\backend\\". $m_b_name_p.".php</li>
<li>=================================================================</li>
<li>routes\breadcrumbs\backend\\". $m_b_name_p."\\". $m_name_s.".php</li>
<li>=================================================================</li>
<li>resources\\views\backend\products\create.blade.php</li>
<li>resources\\views\backend\products\\edit.blade.php</li>
<li>resources\\views\backend\products\\form.blade.php</li>
<li>resources\\views\backend\products\index.blade.php</li>
<li>resources\\views\backend\products\includes\breadcrumb-links.blade.php</li>
<li>resources\\views\backend\products\includes\header-buttons.blade.php</li>
<li>resources\\views\backend\products\show\\tabs\overview.blade.php</li>
<li>=================================================================</li>
</ul>

<p>2 Files were edited:</p>

<ul>
<li>routes\breadcrumbs\backend\backend.php</li>
<li>routes\api.php</li>
<li>=================================================================</li>
</ul>
";