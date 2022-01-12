#!/bin/bash

# To update comments
# http://patorjk.com/software/taag/#p=display&c=bash&f=ANSI%20Shadow&t=Type%20Something%20

function exec_php()
{
    php -r "include 'vendor/autoload.php'; include 'bootstrap/app.php'; $1;"
}

function snake_case()
{
    exec_php "echo Illuminate\Support\Str::snake('$1');"
}

function studly_case()
{
    exec_php "echo Illuminate\Support\Str::studly('$1');"
}

function title_case()
{
    exec_php "echo Illuminate\Support\Str::title(str_replace('_', ' ', Illuminate\Support\Str::snake('$1')));"
}

function str_plural()
{
    exec_php "echo Illuminate\Support\Str::plural('$1');"
}

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██╗   ██╗ █████╗ ██████╗ ██╗ █████╗ ██████╗ ██╗     ███████╗███████╗
#  ██║   ██║██╔══██╗██╔══██╗██║██╔══██╗██╔══██╗██║     ██╔════╝██╔════╝
#  ██║   ██║███████║██████╔╝██║███████║██████╔╝██║     █████╗  ███████╗
#  ╚██╗ ██╔╝██╔══██║██╔══██╗██║██╔══██║██╔══██╗██║     ██╔══╝  ╚════██║
#   ╚████╔╝ ██║  ██║██║  ██║██║██║  ██║██████╔╝███████╗███████╗███████║
#    ╚═══╝  ╚═╝  ╚═╝╚═╝  ╚═╝╚═╝╚═╝  ╚═╝╚═════╝ ╚══════╝╚══════╝╚══════╝
#

if [ -n "$1" ]; then
    domain=$1
else
    read -ep "Domain....: " domain
fi

if [ -n "$2" ]; then
    theme=$2
else
    read -ep "Theme.....: " theme
fi

if [ -n "$3" ]; then
    name=$3
else
    read -ep "Name......: " name
fi

domain_lower=$(snake_case $domain)
theme_lower=$(snake_case $theme)
name_lower=$(snake_case $name)
name_title=$(title_case $name)

table="${domain_lower}_${theme_lower}_$(str_plural $name_lower)"

class_model="Models\\${domain}\\${theme}\\${name}"
class_store_request="${domain}\\${theme}\\${name}\\Store${name}Request"
class_update_request="${domain}\\${theme}\\${name}\\Update${name}Request"
class_controller="${domain}\\${theme}\\${name}Controller"
class_factory="${domain}\\${theme}\\${name}Factory"
class_policy="${domain}\\${theme}\\${name}Policy"
class_repository="Repositories\\${domain}\\${theme}\\${name}Repository"

path_migration="database/migrations/$(date +"%Y_%m_%d_%H%M%S")_create_${table}_table.php"
path_model="app/Models/${domain}/${theme}/${name}.php"
path_store_request="app/Http/Requests/${domain}/${theme}/${name}/Store${name}Request.php"
path_update_request="app/Http/Requests/${domain}/${theme}/${name}/Update${name}Request.php"
path_controller="app/Http/Controllers/${domain}/${theme}/${name}Controller.php"
path_factory="database/factories/${domain}/${theme}/${name}Factory.php"
path_policy="app/Policies/${domain}/${theme}/${name}Policy.php"
path_repository="app/Repositories/${domain}/${theme}/${name}Repository.php"
path_views="resources/views/${domain_lower}/${theme_lower}/${name_lower}"
path_auth_service_provider="app/Providers/${domain}/${theme}/${theme}AuthServiceProvider.php"
path_route_service_provider="app/Providers/${domain}/${theme}/${theme}RouteServiceProvider.php"
path_controller_test="tests/Unit/App/Http/Controllers/${domain}/${theme}/${name}ControllerTest.php"

echo -ne "Generated model is \e[32mApp\\${class_model}\e[0m, continue? \e[33m[Y/n]\e[0m:"
read -e confirm

if [ -n "$confirm" ]  && [ "$confirm" != "Y" ]; then
    exit 1
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███╗   ███╗██╗ ██████╗ ██████╗  █████╗ ████████╗██╗ ██████╗ ███╗   ██╗███████╗
#  ████╗ ████║██║██╔════╝ ██╔══██╗██╔══██╗╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝
#  ██╔████╔██║██║██║  ███╗██████╔╝███████║   ██║   ██║██║   ██║██╔██╗ ██║███████╗
#  ██║╚██╔╝██║██║██║   ██║██╔══██╗██╔══██║   ██║   ██║██║   ██║██║╚██╗██║╚════██║
#  ██║ ╚═╝ ██║██║╚██████╔╝██║  ██║██║  ██║   ██║   ██║╚██████╔╝██║ ╚████║███████║
#  ╚═╝     ╚═╝╚═╝ ╚═════╝ ╚═╝  ╚═╝╚═╝  ╚═╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝
#

read -r -d '' code_migration << EOF
<?php

use Illuminate\\Support\\Facades\\Schema;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Database\\Migrations\\Migration;

class Create$(studly_case $table)Table extends Migration
{
    public function up()
    {
        Schema::create('${table}', function (Blueprint \$table) {
            \$table->uuid('id');
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('${table}');
    }
}
EOF

if ls database/migrations/*_create_${table}_table.php 1> /dev/null 2>&1; then
    echo -e "\e[41mMigration already exists!\e[0m"
else
    echo "$code_migration" > $path_migration
    echo -e "\e[32mMigration created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███╗   ███╗ ██████╗ ██████╗ ███████╗██╗
#  ████╗ ████║██╔═══██╗██╔══██╗██╔════╝██║
#  ██╔████╔██║██║   ██║██║  ██║█████╗  ██║
#  ██║╚██╔╝██║██║   ██║██║  ██║██╔══╝  ██║
#  ██║ ╚═╝ ██║╚██████╔╝██████╔╝███████╗███████╗
#  ╚═╝     ╚═╝ ╚═════╝ ╚═════╝ ╚══════╝╚══════╝
#

read -r -d '' code_model << EOF
<?php

namespace App\\Models\\${domain}\\${theme};

use Addworking\\LaravelHasUuid\\HasUuid;
use Components\Infrastructure\Foundation\Application\\Model\\Routable;
use Components\Infrastructure\Foundation\Application\\Model\\Viewable;
use Illuminate\\Database\\Eloquent\\Model;

class ${name} extends Model
{
    use HasUuid, Routable, Viewable;

    protected \$table = "${table}";

    protected \$fillable = [
        //
    ];

    protected \$routePrefix = "${domain_lower}.${theme_lower}.${name_lower}";

    public function __toString()
    {
        return substr(\$this->id, 0, 8);
    }
}
EOF

if [ ! -d $(dirname $path_model) ]; then
    mkdir -p $(dirname $path_model)
fi

if [ -f $path_model ]; then
    echo -e "\e[41mModel already exists!\e[0m"
else
    echo "$code_model" > $path_model
    echo -e "\e[32mModel created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██████╗ ███████╗ ██████╗ ██╗   ██╗███████╗███████╗████████╗███████╗
#  ██╔══██╗██╔════╝██╔═══██╗██║   ██║██╔════╝██╔════╝╚══██╔══╝██╔════╝
#  ██████╔╝█████╗  ██║   ██║██║   ██║█████╗  ███████╗   ██║   ███████╗
#  ██╔══██╗██╔══╝  ██║▄▄ ██║██║   ██║██╔══╝  ╚════██║   ██║   ╚════██║
#  ██║  ██║███████╗╚██████╔╝╚██████╔╝███████╗███████║   ██║   ███████║
#  ╚═╝  ╚═╝╚══════╝ ╚══▀▀═╝  ╚═════╝ ╚══════╝╚══════╝   ╚═╝   ╚══════╝
#

read -r -d '' code_store_request << EOF
<?php

namespace App\\Http\\Requests\\${domain}\\${theme}\\${name};

use App\\${class_model};
use Illuminate\\Foundation\\Http\\FormRequest;

class Store${name}Request extends FormRequest
{
    public function authorize()
    {
        return \$this->user()->can('create', ${name}::class);
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
EOF

if [ ! -d $(dirname $path_store_request) ]; then
    mkdir -p $(dirname $path_store_request)
fi

if [ -f $path_store_request ]; then
    echo -e "\e[41mStore request already exists!\e[0m"
else
    echo "$code_store_request" > $path_store_request
    echo -e "\e[32mStore request created successfully.\e[0m"
fi

read -r -d '' code_update_request << EOF
<?php

namespace App\\Http\\Requests\\${domain}\\${theme}\\${name};

use App\\${class_model};
use Illuminate\\Foundation\\Http\\FormRequest;

class Update${name}Request extends FormRequest
{
    public function authorize()
    {
        return \$this->user()->can('update', \$this->route('${name_lower}'));
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
EOF

if [ ! -d $(dirname $path_update_request) ]; then
    mkdir -p $(dirname $path_update_request)
fi

if [ -f $path_update_request ]; then
    echo -e "\e[41mUpdate request already exists!\e[0m"
else
    echo "$code_update_request" > $path_update_request
    echo -e "\e[32mUpdate request created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#   ██████╗ ██████╗ ███╗   ██╗████████╗██████╗  ██████╗ ██╗     ██╗     ███████╗██████╗
#  ██╔════╝██╔═══██╗████╗  ██║╚══██╔══╝██╔══██╗██╔═══██╗██║     ██║     ██╔════╝██╔══██╗
#  ██║     ██║   ██║██╔██╗ ██║   ██║   ██████╔╝██║   ██║██║     ██║     █████╗  ██████╔╝
#  ██║     ██║   ██║██║╚██╗██║   ██║   ██╔══██╗██║   ██║██║     ██║     ██╔══╝  ██╔══██╗
#  ╚██████╗╚██████╔╝██║ ╚████║   ██║   ██║  ██║╚██████╔╝███████╗███████╗███████╗██║  ██║
#   ╚═════╝ ╚═════╝ ╚═╝  ╚═══╝   ╚═╝   ╚═╝  ╚═╝ ╚═════╝ ╚══════╝╚══════╝╚══════╝╚═╝  ╚═╝
#

read -r -d '' code_controller << EOF
<?php

namespace App\\Http\\Controllers\\${domain}\\${theme};

use App\\${class_model};
use App\\Http\\Requests\\${class_store_request};
use App\\Http\\Requests\\${class_update_request};
use App\\Http\\Controllers\\Controller;
use App\\${class_repository};
use Components\Infrastructure\Foundation\Application\\Http\\Controller\\HandlesIndex;
use Illuminate\\Http\\Request;

class ${name}Controller extends Controller
{
    use HandlesIndex;

    protected \$repository;

    public function __construct(${name}Repository \$repository)
    {
        \$this->repository = \$repository;
    }

    public function index(Request \$request)
    {
        \$this->authorize('viewAny', ${name}::class);

        \$items = \$this->getPaginatorFromRequest(\$request);

        return view('${domain_lower}.${theme_lower}.${name_lower}.index', @compact('items'));
    }

    public function create()
    {
        \$this->authorize('create', ${name}::class);

        \$${name_lower} = \$this->repository->make();

        return view('${domain_lower}.${theme_lower}.${name_lower}.create', @compact('${name_lower}'));
    }

    public function store(Store${name}Request \$request)
    {
        \$this->authorize('create', ${name}::class);

        \$${name_lower} = \$this->repository->createFromRequest(\$request);

        return \$this->redirectWhen(\$${name_lower}->exists, \$${name_lower}->routes->show);
    }

    public function show(${name} \$${name_lower})
    {
        \$this->authorize('view', \$${name_lower});

        return view('${domain_lower}.${theme_lower}.${name_lower}.show', @compact('${name_lower}'));
    }

    public function edit(${name} \$${name_lower})
    {
        \$this->authorize('update', \$${name_lower});

        return view('${domain_lower}.${theme_lower}.${name_lower}.edit', @compact('${name_lower}'));
    }

    public function update(Update${name}Request \$request, ${name} \$${name_lower})
    {
        \$this->authorize('update', \$${name_lower});

        \$${name_lower} = \$this->repository->updateFromRequest(\$request, \$${name_lower});

        return \$this->redirectWhen(\$${name_lower}->exists, \$${name_lower}->routes->show);
    }

    public function destroy(${name} \$${name_lower})
    {
        \$this->authorize('delete', \$${name_lower});

        \$deleted = \$this->repository->delete(\$${name_lower});

        return \$this->redirectWhen(\$deleted, \$${name_lower}->routes->index);
    }
}
EOF

if [ ! -d $(dirname $path_controller) ]; then
    mkdir -p $(dirname $path_controller)
fi

if [ -f $path_controller ]; then
    echo -e "\e[41mController already exists!\e[0m"
else
    echo "$code_controller" > $path_controller
    echo -e "\e[32mController created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███████╗ █████╗  ██████╗████████╗ ██████╗ ██████╗ ██╗   ██╗
#  ██╔════╝██╔══██╗██╔════╝╚══██╔══╝██╔═══██╗██╔══██╗╚██╗ ██╔╝
#  █████╗  ███████║██║        ██║   ██║   ██║██████╔╝ ╚████╔╝
#  ██╔══╝  ██╔══██║██║        ██║   ██║   ██║██╔══██╗  ╚██╔╝
#  ██║     ██║  ██║╚██████╗   ██║   ╚██████╔╝██║  ██║   ██║
#  ╚═╝     ╚═╝  ╚═╝ ╚═════╝   ╚═╝    ╚═════╝ ╚═╝  ╚═╝   ╚═╝
#

read -r -d '' code_factory << EOF
<?php

use App\\${class_model};
use Faker\Generator as Faker;

\$factory->define(${name}::class, function (Faker \$faker) {
    return [
        //
    ];
});
EOF

if [ ! -d $(dirname $path_factory) ]; then
    mkdir -p $(dirname $path_factory)
fi

if [ -f $path_factory ]; then
    echo -e "\e[41mFactory already exists!\e[0m"
else
    echo "$code_factory" > $path_factory
    echo -e "\e[32mFactory created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██████╗  ██████╗ ██╗     ██╗ ██████╗██╗   ██╗
#  ██╔══██╗██╔═══██╗██║     ██║██╔════╝╚██╗ ██╔╝
#  ██████╔╝██║   ██║██║     ██║██║      ╚████╔╝
#  ██╔═══╝ ██║   ██║██║     ██║██║       ╚██╔╝
#  ██║     ╚██████╔╝███████╗██║╚██████╗   ██║
#  ╚═╝      ╚═════╝ ╚══════╝╚═╝ ╚═════╝   ╚═╝
#

read -r -d '' code_policy << EOF
<?php

namespace App\\Policies\\${domain}\\${theme};

use App\\Models\\Addworking\\User\\User;
use App\\${class_model};
use Illuminate\\Auth\\Access\\HandlesAuthorization;

class ${name}Policy
{
    use HandlesAuthorization;

    public function viewAny(User \$user)
    {
        return true;
    }

    public function view(User \$user, ${name} \$${name_lower})
    {
        return true;
    }

    public function create(User \$user)
    {
        return true;
    }

    public function update(User \$user, ${name} \$${name_lower})
    {
        return true;
    }

    public function delete(User \$user, ${name} \$${name_lower})
    {
        return true;
    }

    public function restore(User \$user, ${name} \$${name_lower})
    {
        return true;
    }

    public function forceDelete(User \$user, ${name} \$${name_lower})
    {
        return true;
    }
}

EOF

if [ ! -d $(dirname $path_policy) ]; then
    mkdir -p $(dirname $path_policy)
fi

if [ -f $path_policy ]; then
    echo -e "\e[41mPolicy already exists!\e[0m"
else
    echo "$code_policy" > $path_policy
    echo -e "\e[32mPolicy created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██████╗ ███████╗██████╗  ██████╗ ███████╗██╗████████╗ ██████╗ ██████╗ ██╗   ██╗
#  ██╔══██╗██╔════╝██╔══██╗██╔═══██╗██╔════╝██║╚══██╔══╝██╔═══██╗██╔══██╗╚██╗ ██╔╝
#  ██████╔╝█████╗  ██████╔╝██║   ██║███████╗██║   ██║   ██║   ██║██████╔╝ ╚████╔╝
#  ██╔══██╗██╔══╝  ██╔═══╝ ██║   ██║╚════██║██║   ██║   ██║   ██║██╔══██╗  ╚██╔╝
#  ██║  ██║███████╗██║     ╚██████╔╝███████║██║   ██║   ╚██████╔╝██║  ██║   ██║
#  ╚═╝  ╚═╝╚══════╝╚═╝      ╚═════╝ ╚══════╝╚═╝   ╚═╝    ╚═════╝ ╚═╝  ╚═╝   ╚═╝
#

read -r -d '' code_repository << EOF
<?php

namespace App\\Repositories\\${domain}\\${theme};

use App\\Contracts\\Models\\Repository;
use App\\Http\\Requests\\${class_store_request};
use App\\Http\\Requests\\${class_update_request};
use App\\Repositories\\BaseRepository;
use App\\${class_model};

class ${name}Repository extends BaseRepository
{
    protected \$model = ${name}::class;

    public function createFromRequest(Store${name}Request \$request): ${name}
    {
        return \$this->create(\$request->input('${name_lower}', []));
    }

    public function updateFromRequest(Update${name}Request \$request, ${name} \$${name_lower}): ${name}
    {
        return \$this->update(\$${name_lower}, \$request->input('${name_lower}', []));
    }
}
EOF

if [ ! -d $(dirname $path_repository) ]; then
    mkdir -p $(dirname $path_repository)
fi

if [ -f $path_repository ]; then
    echo -e "\e[41mRepository already exists!\e[0m"
else
    echo "$code_repository" > $path_repository
    echo -e "\e[32mRepository created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██╗   ██╗██╗███████╗██╗    ██╗███████╗    ██████╗  █████╗ ████████╗██╗  ██╗
#  ██║   ██║██║██╔════╝██║    ██║██╔════╝    ██╔══██╗██╔══██╗╚══██╔══╝██║  ██║
#  ██║   ██║██║█████╗  ██║ █╗ ██║███████╗    ██████╔╝███████║   ██║   ███████║
#  ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║╚════██║    ██╔═══╝ ██╔══██║   ██║   ██╔══██║
#   ╚████╔╝ ██║███████╗╚███╔███╔╝███████║    ██║     ██║  ██║   ██║   ██║  ██║
#    ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝ ╚══════╝    ╚═╝     ╚═╝  ╚═╝   ╚═╝   ╚═╝  ╚═╝
#

if [ ! -d $path_views ]; then
    mkdir -p $path_views
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#   █████╗  ██████╗████████╗██╗ ██████╗ ███╗   ██╗███████╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██╔══██╗██╔════╝╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝    ██║   ██║██║██╔════╝██║    ██║
#  ███████║██║        ██║   ██║██║   ██║██╔██╗ ██║███████╗    ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██╔══██║██║        ██║   ██║██║   ██║██║╚██╗██║╚════██║    ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ██║  ██║╚██████╗   ██║   ██║╚██████╔╝██║ ╚████║███████║     ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚═╝  ╚═╝ ╚═════╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝      ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_actions << EOF
@actions(\$${name_lower})
EOF

if [ -f $path_views/_actions.blade.php ]; then
    echo -e "\e[41mActions view already exists!\e[0m"
else
    echo "$code_view_actions" > $path_views/_actions.blade.php
    echo -e "\e[32mActions view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███████╗ ██████╗ ██████╗ ███╗   ███╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██╔════╝██╔═══██╗██╔══██╗████╗ ████║    ██║   ██║██║██╔════╝██║    ██║
#  █████╗  ██║   ██║██████╔╝██╔████╔██║    ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██╔══╝  ██║   ██║██╔══██╗██║╚██╔╝██║    ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ██║     ╚██████╔╝██║  ██║██║ ╚═╝ ██║     ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝      ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_form << EOF
<fieldset class="mt-5 pt-2">
    <legend class="text-primary h5">@icon('info') Informations Générales</legend>

    {{--
    @form_group([
        'text'  => "",
        'name'  => "${name_lower}.foo",
        'value' => \$${name_lower}->foo,
    ])
    --}}
</fieldset>
EOF

if [ -f $path_views/_form.blade.php ]; then
    echo -e "\e[41mForm view already exists!\e[0m"
else
    echo "$code_view_form" > $path_views/_form.blade.php
    echo -e "\e[32mForm view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██╗  ██╗████████╗███╗   ███╗██╗         ██╗   ██╗██╗███████╗██╗    ██╗
#  ██║  ██║╚══██╔══╝████╗ ████║██║         ██║   ██║██║██╔════╝██║    ██║
#  ███████║   ██║   ██╔████╔██║██║         ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██╔══██║   ██║   ██║╚██╔╝██║██║         ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ██║  ██║   ██║   ██║ ╚═╝ ██║███████╗     ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚═╝  ╚═╝   ╚═╝   ╚═╝     ╚═╝╚══════╝      ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_html << EOF
<div class="row">
    <div class="col-md-8">
        @attribute("{\$${name_lower}}|icon:tag|label:Label")
    </div>
    <div class="col-md-4">
        @attribute("{\$${name_lower}->id}|icon:id-card-alt|label:Identifiant")
        @attribute("{\$${name_lower}->created_at}|icon:calendar-plus|label:Date de création")
        @attribute("{\$${name_lower}->updated_at}|icon:calendar-check|label:Date de dernière modification")
    </div>
</div>
EOF

if [ -f $path_views/_html.blade.php ]; then
    echo -e "\e[41mHtml view already exists!\e[0m"
else
    echo "$code_view_html" > $path_views/_html.blade.php
    echo -e "\e[32mHtml view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██╗     ██╗███╗   ██╗██╗  ██╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██║     ██║████╗  ██║██║ ██╔╝    ██║   ██║██║██╔════╝██║    ██║
#  ██║     ██║██╔██╗ ██║█████╔╝     ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██║     ██║██║╚██╗██║██╔═██╗     ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ███████╗██║██║ ╚████║██║  ██╗     ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚══════╝╚═╝╚═╝  ╚═══╝╚═╝  ╚═╝      ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_link << EOF
@link(\$${name_lower})
EOF

if [ -f $path_views/_link.blade.php ]; then
    echo -e "\e[41mLink view already exists!\e[0m"
else
    echo "$code_view_link" > $path_views/_link.blade.php
    echo -e "\e[32mLink view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#   ██████╗██████╗ ███████╗ █████╗ ████████╗███████╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██╔════╝██╔══██╗██╔════╝██╔══██╗╚══██╔══╝██╔════╝    ██║   ██║██║██╔════╝██║    ██║
#  ██║     ██████╔╝█████╗  ███████║   ██║   █████╗      ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██║     ██╔══██╗██╔══╝  ██╔══██║   ██║   ██╔══╝      ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ╚██████╗██║  ██║███████╗██║  ██║   ██║   ███████╗     ╚████╔╝ ██║███████╗╚███╔███╔╝
#   ╚═════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝   ╚═╝   ╚══════╝      ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_create << EOF
@extends('foundation::layout.app.create', ['action' => \$${name_lower}->routes->create])

@section('title', "Créer ${name_title}")

@section('toolbar')
    @button("Retour|href:{\$${name_lower}->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item"><a href="{{ \$${name_lower}->routes->index }}">${name_title}</a></li>
    <li class="breadcrumb-item">${name_title}</li>
    <li class="breadcrumb-item active">Créer</li>
@endsection

@section('content')
    {{ \$${name_lower}->views->form }}

    @button("Créer|icon:save|type:submit")
@endsection
EOF

if [ -f $path_views/create.blade.php ]; then
    echo -e "\e[41mCreate view already exists!\e[0m"
else
    echo "$code_view_create" > $path_views/create.blade.php
    echo -e "\e[32mCreate view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███████╗██████╗ ██╗████████╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██╔════╝██╔══██╗██║╚══██╔══╝    ██║   ██║██║██╔════╝██║    ██║
#  █████╗  ██║  ██║██║   ██║       ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██╔══╝  ██║  ██║██║   ██║       ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ███████╗██████╔╝██║   ██║        ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚══════╝╚═════╝ ╚═╝   ╚═╝         ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_edit << EOF
@extends('foundation::layout.app.edit', ['action' => \$${name_lower}->routes->update])

@section('title', "Modifier \$${name_lower}")

@section('toolbar')
    @button("Retour|href:{\$${name_lower}->routes->show}|icon:arrow-left|color:secondary|outline|sm|mr:2")
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item"><a href="{{ \$${name_lower}->routes->index }}">${name_title}</a></li>
    <li class="breadcrumb-item"><a href="{{ \$${name_lower}->routes->show }}">{{ \$${name_lower} }}</li>
    <li class="breadcrumb-item active">Modifier</li>
@endsection

@section('content')
    {{ \$${name_lower}->views->form }}

    @button("Enregistrer|icon:save|type:submit")
@endsection
EOF

if [ -f $path_views/edit.blade.php ]; then
    echo -e "\e[41mEdit view already exists!\e[0m"
else
    echo "$code_view_edit" > $path_views/edit.blade.php
    echo -e "\e[32mEdit view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██╗███╗   ██╗██████╗ ███████╗██╗  ██╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██║████╗  ██║██╔══██╗██╔════╝╚██╗██╔╝    ██║   ██║██║██╔════╝██║    ██║
#  ██║██╔██╗ ██║██║  ██║█████╗   ╚███╔╝     ██║   ██║██║█████╗  ██║ █╗ ██║
#  ██║██║╚██╗██║██║  ██║██╔══╝   ██╔██╗     ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ██║██║ ╚████║██████╔╝███████╗██╔╝ ██╗     ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚═╝╚═╝  ╚═══╝╚═════╝ ╚══════╝╚═╝  ╚═╝      ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_index << EOF
@extends('foundation::layout.app.index')

@section('title', "${name}")

@section('toolbar')
    @can('create', ${name_lower}())
        @button(sprintf("Ajouter|href:%s|icon:plus|color:outline-success|outline|sm", ${name_lower}([])->routes->create))
    @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item active">${name_title}</li>
@endsection

@section('table.head')
    {{--
    <th>XXXX</th>
    <th>YYYY</th>
    <th>ZZZZ</th>
    --}}
@endsection

@section('table.pagination')
    {{ \$items->links() }}
@endsection

@section('table.body')
    @forelse (\$items as \$${name_lower})
        {{--
        <td>XXXX</td>
        <td>YYYY</td>
        <td>ZZZZ</td>
        --}}
    @empty
        <tr>
            <td colspan="999">@lang('messages.empty')</td>
        </tr>
    @endforelse
@endsection
EOF

if [ -f $path_views/index.blade.php ]; then
    echo -e "\e[41mIndex view already exists!\e[0m"
else
    echo "$code_view_index" > $path_views/index.blade.php
    echo -e "\e[32mIndex view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███████╗██╗  ██╗ ██████╗ ██╗    ██╗    ██╗   ██╗██╗███████╗██╗    ██╗
#  ██╔════╝██║  ██║██╔═══██╗██║    ██║    ██║   ██║██║██╔════╝██║    ██║
#  ███████╗███████║██║   ██║██║ █╗ ██║    ██║   ██║██║█████╗  ██║ █╗ ██║
#  ╚════██║██╔══██║██║   ██║██║███╗██║    ╚██╗ ██╔╝██║██╔══╝  ██║███╗██║
#  ███████║██║  ██║╚██████╔╝╚███╔███╔╝     ╚████╔╝ ██║███████╗╚███╔███╔╝
#  ╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚══╝╚══╝       ╚═══╝  ╚═╝╚══════╝ ╚══╝╚══╝
#

read -r -d '' code_view_show << EOF
@extends('foundation::layout.app.show')

@section('title', \$${name_lower})

@section('toolbar')
    @button("Retour|href:{\$${name_lower}->routes->index}|icon:arrow-left|color:secondary|outline|sm|mr:2")
    {{ \$${name_lower}->views->actions }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
    <li class="breadcrumb-item"><a href="{{ \$${name_lower}->routes->index }}">${name_title}</a></li>
    <li class="breadcrumb-item active">{{ \$${name_lower} }}</li>
@endsection

@section('content')
    {{ \$${name_lower}->views->html }}
@endsection
EOF

if [ -f $path_views/show.blade.php ]; then
    echo -e "\e[41mShow view already exists!\e[0m"
else
    echo "$code_view_show" > $path_views/show.blade.php
    echo -e "\e[32mShow view created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#   █████╗ ██╗   ██╗████████╗██╗  ██╗
#  ██╔══██╗██║   ██║╚══██╔══╝██║  ██║
#  ███████║██║   ██║   ██║   ███████║
#  ██╔══██║██║   ██║   ██║   ██╔══██║
#  ██║  ██║╚██████╔╝   ██║   ██║  ██║
#  ╚═╝  ╚═╝ ╚═════╝    ╚═╝   ╚═╝  ╚═╝
#

read -r -d '' code_auth_service_provider << EOF
<?php

namespace App\\Providers\\${domain}\\${theme};

use Illuminate\\Foundation\\Support\\Providers\\AuthServiceProvider as ServiceProvider;

class ${theme}AuthServiceProvider extends ServiceProvider
{
    protected \$policies = [
        'App\\${class_model}' => "App\\Policies\\${class_policy}",
    ];

    public function boot()
    {
        \$this->registerPolicies();
    }
}

EOF

if [ ! -d $(dirname $path_auth_service_provider) ]; then
    mkdir -p $(dirname $path_auth_service_provider)
fi

if [ -f $path_auth_service_provider ]; then
    echo -e "\e[41mAuth service provider already exists!\e[0m"
    flag_auth_service_provider=1
else
    echo "$code_auth_service_provider" > $path_auth_service_provider
    echo -e "\e[32mAuth service provider created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ██████╗  ██████╗ ██╗   ██╗████████╗███████╗
#  ██╔══██╗██╔═══██╗██║   ██║╚══██╔══╝██╔════╝
#  ██████╔╝██║   ██║██║   ██║   ██║   █████╗
#  ██╔══██╗██║   ██║██║   ██║   ██║   ██╔══╝
#  ██║  ██║╚██████╔╝╚██████╔╝   ██║   ███████╗
#  ╚═╝  ╚═╝ ╚═════╝  ╚═════╝    ╚═╝   ╚══════╝
#

read -r -d '' code_route_service_provider_map_method << EOF
    public function map${name}()
    {
        Route::middleware(['web', 'auth'])
            ->namespace(\$this->namespace)
            ->group(function () {
                Route::get('${domain_lower}/${name_lower}', [
                    'uses' => "${name}Controller@index",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.index",
                ]);

                Route::get('${domain_lower}/${name_lower}/create', [
                    'uses' => "${name}Controller@create",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.create",
                ]);

                Route::post('${domain_lower}/${name_lower}', [
                    'uses' => "${name}Controller@store",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.store",
                ]);

                Route::get('${domain_lower}/${name_lower}/{${name_lower}}', [
                    'uses' => "${name}Controller@show",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.show",
                ]);

                Route::get('${domain_lower}/${name_lower}/{${name_lower}}/edit', [
                    'uses' => "${name}Controller@edit",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.edit",
                ]);

                Route::put('${domain_lower}/${name_lower}/{${name_lower}}', [
                    'uses' => "${name}Controller@update",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.update",
                ]);

                Route::delete('${domain_lower}/${name_lower}/{${name_lower}}', [
                    'uses' => "${name}Controller@destroy",
                    'as'   => "${domain_lower}.${theme_lower}.${name_lower}.destroy",
                ]);
            });
    }
EOF

read -r -d '' code_route_service_provider << EOF
<?php

namespace App\\Providers\\${domain}\\${theme};

use Illuminate\\Support\\Facades\\Route;
use Illuminate\\Foundation\\Support\\Providers\\RouteServiceProvider as ServiceProvider;

class EnterpriseRouteServiceProvider extends ServiceProvider
{
    protected \$namespace = 'App\\Http\\Controllers\\${domain}\\${theme}';

    public function map()
    {
        // @todo put this in a trait!
        foreach (get_class_methods(self::class) as \$method) {
            if (preg_match('/^map/', \$method)) {
                \$this->\$method();
            }
        }
    }

    ${code_route_service_provider_map_method}
}

EOF

if [ ! -d $(dirname $path_route_service_provider) ]; then
    mkdir -p $(dirname $path_route_service_provider)
fi

if [ -f $path_route_service_provider ]; then
    echo -e "\e[41mRoute service provider already exists!\e[0m"
    flag_route_service_provider=1
else
    echo "$code_route_service_provider" > $path_route_service_provider
    echo -e "\e[32mRoute service provider created successfully.\e[0m"
fi

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ████████╗███████╗███████╗████████╗███████╗
#  ╚══██╔══╝██╔════╝██╔════╝╚══██╔══╝██╔════╝
#     ██║   █████╗  ███████╗   ██║   ███████╗
#     ██║   ██╔══╝  ╚════██║   ██║   ╚════██║
#     ██║   ███████╗███████║   ██║   ███████║
#     ╚═╝   ╚══════╝╚══════╝   ╚═╝   ╚══════╝
#

read -r -d '' code_controller_test << EOF
<?php

namespace Tests\\Unit\\App\\Http\\Controllers\\${domain}\\${theme};

use App\\Http\\Controllers\\Controller;
use App\\Http\\Controllers\\${class_controller};
use App\\Models\\Addworking\\User\\User;
use App\\${class_model};
use Illuminate\\Foundation\\Testing\\RefreshDatabase;
use Illuminate\\Foundation\\Testing\\WithFaker;
use Tests\\TestCase;

class ${name}ControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        \$this->assertInstanceof(
            Controller::class,
            \$this->app->make(${name}Controller::class),
            "The controller should be a controller"
        );
    }

    public function testIndex()
    {
        \$$(str_plural $name_lower) = factory(${name}::class, 5)->create();
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->get((new ${name})->routes->index);

        \$response->assertOk();
        \$response->assertViewIs('${domain_lower}.${theme_lower}.${name_lower}.index');
        \$response->assertViewHas('items');

        \$items = \$response->viewData('items');

        \$this->assertEquals(5, \$items->total(), "There should be 5 $(str_plural $name_lower) in database");
    }

    public function testCreate()
    {
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->get((new ${name})->routes->create);

        \$response->assertOk();
        \$response->assertViewIs('${domain_lower}.${theme_lower}.${name_lower}.create');
    }

    public function testStore()
    {
        \$data = factory(${name}::class)->make()->toArray();
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->post((new ${name})->routes->store, \$data);

        \$this->assertDatabaseHas((new ${name})->getTable(), \$data);
    }

    public function testShow()
    {
        \$${name_lower} = factory(${name}::class)->create();
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->get(\$${name_lower}->routes->show);

        \$response->assertOk();
        \$response->assertViewIs('${domain_lower}.${theme_lower}.${name_lower}.show');
    }

    public function testEdit()
    {
        \$${name_lower} = factory(${name}::class)->create();
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->get(\$${name_lower}->routes->edit);

        \$response->assertOk();
        \$response->assertViewIs('${domain_lower}.${theme_lower}.${name_lower}.edit');
    }

    public function testUpdate()
    {
        \$data = factory(${name}::class)->make()->toArray();
        \$${name_lower} = factory(${name}::class)->create();
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->put(\$${name_lower}->routes->update, \$data);

        \$this->assertDatabaseHas((new ${name})->getTable(), \$data);
    }

    public function testDestroy()
    {
        \$${name_lower} = factory(${name}::class)->create();
        \$user = factory(User::class)->state('support')->create();
        \$response = \$this->actingAs(\$user)->delete(\$${name_lower}->routes->destroy);

        \$this->assertDatabaseMissing((new ${name})->getTable(), \$${name_lower}->toArray());
    }
}

EOF

if [ ! -d $(dirname $path_controller_test) ]; then
    mkdir -p $(dirname $path_controller_test)
fi

if [ -f $path_controller_test ]; then
    echo -e "\e[41mController test already exists!\e[0m"
else
    echo "$code_controller_test" > $path_controller_test
    echo -e "\e[32mController test created successfully.\e[0m"
fi

php artisan make:test --unit "App\\${class_model}Test"
php artisan make:test --unit "App\\Http\\Requests\\${class_store_request}Test"
php artisan make:test --unit "App\\Http\\Requests\\${class_update_request}Test"
php artisan make:test --unit "App\\Policies\\${class_policy}Test"
php artisan make:test --unit "App\\Providers\\${domain}\\${theme}\\${theme}AuthServiceProviderTest"
php artisan make:test --unit "App\\Providers\\${domain}\\${theme}\\${theme}RouteServiceProviderTest"

#
#  ███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗███████╗
#  ╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝╚══════╝
#
#  ███╗   ███╗ █████╗ ███╗   ██╗██╗   ██╗ █████╗ ██╗
#  ████╗ ████║██╔══██╗████╗  ██║██║   ██║██╔══██╗██║
#  ██╔████╔██║███████║██╔██╗ ██║██║   ██║███████║██║
#  ██║╚██╔╝██║██╔══██║██║╚██╗██║██║   ██║██╔══██║██║
#  ██║ ╚═╝ ██║██║  ██║██║ ╚████║╚██████╔╝██║  ██║███████╗
#  ╚═╝     ╚═╝╚═╝  ╚═╝╚═╝  ╚═══╝ ╚═════╝ ╚═╝  ╚═╝╚══════╝
#

if [ "${flag_route_service_provider:-0}" -eq 1 ]; then
    echo -e "\nAdd this to \e[32m${path_route_service_provider}\e[0m:\n"
    echo "    ${code_route_service_provider_map_method}"
fi

read -r -d '' code_auth << EOF
    protected \$policies = [
        'App\\${class_model}' => 'App\\${class_policy}',
    ];
EOF

if [ "${flag_auth_service_provider:-0}" -eq 1 ]; then
    echo -e "\nAdd this to \e[32m${path_auth_service_provider}\e[0m:\n"
    echo "    ${code_auth}"
fi

echo -e "\nAdd this to \e[32mconfig/app.php\e[0m:\n"
echo "    App\\Providers\\${domain}\\${theme}\\${theme}RouteServiceProvider::class,"
echo "    App\\Providers\\${domain}\\${theme}\\${theme}AuthServiceProvider::class,"
