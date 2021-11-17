# laravel8_crud
简单的laravel8 crud示例


在本教程中,想展示Laravel 8 Crud操作示例。

步骤1:安装Laravel 8

首先,安装最新版本Laravel框架。

composer create-project --prefer-dist laravel/laravel blog

步骤2:数据库配置

在第二步中,我们将使数据库配置进行数据库配置,例如我们的Crud应用程序的数据库名称,用户名,密码等。因此,让我们打开.env文件并填充.

```env
.env

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=数据库名

DB_USERNAME=数据库帐号

DB_PASSWORD=数据库密码

```

参考阅读: Laravel 8 - 新函数

步骤3:创建迁移

我们将为Product表创建Crud应用程序。所以我们使用Laravel 8 PHP Artisan命令为"Products"表创建迁移:

php artisan make:migration create_products_table --create=products

在此命令之后,您将在以下路径"database/migrations"中找到一个文件。

```php

  

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

  

class CreateProductsTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->text('detail');

            $table->timestamps();

        });

    }

  

    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::dropIfExists('products');

    }

}
```

现在,通过以下命令运行此迁移:

```powershell
php artisan migrate
```

步骤4:添加资源路由

此处,我们需要为Product 创建CRUD资源路由。打开"routes/web.php"文件并添加以下路由。

```php
routes/web.php

use App\Http\Controllers\ProductController;

  

Route::resource('products', ProductController::class);
```

步骤5:添加控制器和模型

在此步骤中,现在将新的控制器创建为ProductController,运行以下命令并创建新控制器。
```php

php artisan make:controller ProductController --resource --model=Product
```

命令后,您将在此路径中找到新文件"app/Http/Controllers/ProductController.php"。

在此控制器中,默认情况下将创建七种方法:

        1)index()   -  首页调用

        2)create()  -  跳转到创建页面调用

        3)store()    -  新增保存时调用

        4)show()    -  查看时调用

        5)edit()      -  跳转到修改页面调用

        6)update() - 更新时调用

        7)destroy() - 删除时调用

所以,让我们复制代码并放在ProductController.php文件中。

app/Http/Controller/ProductController.php

```php

  

namespace App\Http\Controllers;

   

use App\Models\Product;

use Illuminate\Http\Request;

  

class ProductController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $products = Product::latest()->paginate(5);

    

        return view('products.index',compact('products'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

     

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('products.create');

    }

    

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $request->validate([

            'name' => 'required',

            'detail' => 'required',

        ]);

    

        Product::create($request->all());

     

        return redirect()->route('products.index')

                        ->with('success','Product created successfully.');

    }

     

    /**

     * Display the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function show(Product $product)

    {

        return view('products.show',compact('product'));

    } 

     

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit(Product $product)

    {

        return view('products.edit',compact('product'));

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Product $product)

    {

        $request->validate([

            'name' => 'required',

            'detail' => 'required',

        ]);

    

        $product->update($request->all());

    

        return redirect()->route('products.index')

                        ->with('success','Product updated successfully');

    }

    

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy(Product $product)

    {

        $product->delete();

    

        return redirect()->route('products.index')

                        ->with('success','Product deleted successfully');

    }

}

```

好的,所以在运行命令后,您将找到"app/Models/Product.php"并将内容复制进Product.php文件:

app/Models/Product.php

```php

  

namespace App\Models;

  

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

  

class Product extends Model

{

    use HasFactory;

  

    protected $fillable = [

        'name', 'detail'

    ];

}
```
步骤6:添加视图页面

在最后一步。我们创建Blade视图文件。先创建布局文件,然后创建新文件夹"products",最后创建Crud对应的的blade页面。

        1)layout.blade.php      -  布局文件

        2)index.blade.php       -  列表页文件

        3)create.blade.php      -  新增页文件

        4)edit.Blade.php          -  修改页文件

        5)show.blade.php        -  查看页文件

所以让我们只是创建以下文件并将代码放在下面。

resources/views/products/layout.blade.php

```html

<!DOCTYPE html>

<html>

<head>

    <title>Laravel 8 CRUD Application</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">

</head>

<body>

  

<div class="container">

    @yield('content')

</div>

   

</body>

</html>
```

resources/views/products/index.blade.php
```html

@extends('products.layout')

 

@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2>Laravel 8 CRUD Example from scratch - ItSolutionStuff.com</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>

            </div>

        </div>

    </div>

   

    @if ($message = Session::get('success'))

        <div class="alert alert-success">

            <p>{{ $message }}</p>

        </div>

    @endif

   

    <table class="table table-bordered">

        <tr>

            <th>No</th>

            <th>Name</th>

            <th>Details</th>

            <th width="280px">Action</th>

        </tr>

        @foreach ($products as $product)

        <tr>

            <td>{{ ++$i }}</td>

            <td>{{ $product->name }}</td>

            <td>{{ $product->detail }}</td>

            <td>

                <form action="{{ route('products.destroy',$product->id) }}" method="POST">

   

                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>

    

                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>

   

                    @csrf

                    @method('DELETE')

      

                    <button type="submit" class="btn btn-danger">Delete</button>

                </form>

            </td>

        </tr>

        @endforeach

    </table>

  

    {!! $products->links() !!}

      

@endsection

```

resources/views/products/create.blade.php

```html
@extends('products.layout')

  

@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Add New Product</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>

        </div>

    </div>

</div>

   

@if ($errors->any())

    <div class="alert alert-danger">

        <strong>Whoops!</strong> There were some problems with your input.<br><br>

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

   

<form action="{{ route('products.store') }}" method="POST">

    @csrf

  

     <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Name:</strong>

                <input type="text" name="name" class="form-control" placeholder="Name">

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Detail:</strong>

                <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </div>

   

</form>

@endsection
```

resources/views/products/edit.blade.php

```html

@extends('products.layout')

   

@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2>Edit Product</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>

            </div>

        </div>

    </div>

   

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

  

    <form action="{{ route('products.update',$product->id) }}" method="POST">

        @csrf

        @method('PUT')

   

         <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>Name:</strong>

                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Name">

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>Detail:</strong>

                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $product->detail }}</textarea>

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">

              <button type="submit" class="btn btn-primary">Submit</button>

            </div>

        </div>

   

    </form>

@endsection
```

resources/views/products/show.blade.php

```html

@extends('products.layout')

  

@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2> Show Product</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>

            </div>

        </div>

    </div>

   

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Name:</strong>

                {{ $product->name }}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Details:</strong>

                {{ $product->detail }}

            </div>

        </div>

    </div>

@endsection

```

现在我们使用Laravel 8 命令行运行我们的示例,因此运行命令运行:

```php

php artisan serve
```

现在,您可以在浏览器上打开以下URL:

http://localhost:8000/products


#### 增加了Autocomplete搜索 
#### 增加了Excel和CSV导入,导出  
#### 增加了Pagination分页  
#### 增加了文件上传  
#### 增加了自定义函数助手 
#### 增加了表格验证  