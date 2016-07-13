## Abaut SIMPLE807
### Simple framework. Fast and easy. Designed by davi807

* Main controller name == **controllerName**_controller.php
* All controllers recomended to have indexAction function if Routing not enabled


**[link] vs mklink(link)**
```html  
  example #1
   <form action="[myaddr/url]">
    <input value="10" name="a">
    <input type="submit">
   </form>
  result url:
    http://yourdomain.com/myaddr/10
```
```html  
  example #2
   <form action="<?=mklink("myaddr/url")?>">
    <input value="10" name="a">
    <input type="submit">
   </form>
  result url:
    http://yourdomain.com/myaddr?a=10
``` 
**Note:** [ ] not working for post method

*****************
*****************

#### DEFINES 
* APP = app/
* ROOT_ADDR = query root address
* HEAP = config folder for libs 
* IMPORT = castum functionality folder
* 
* CTRL = controllers dir
* MOD = models dir
* TPL = templates dir
* PUB = public dir
*
* LIB = librery dir
* LIBDATA = HEAP.'__libdata__'
* 
* IS_GET = Is request method get
* IS_POST = Is request method post

*****************
*****************

#### Import

* Import($file,[bool $once=true, bool $required=false) = load 'src/import/$file.php'    

*****************
*****************

#### Shotcuts
 
* href(string $href, [string $k=", bool $enable_pub = false]) = return href using ROOT_ADDR 
* src(string $src, [string $k="]) = return src from PUB folder
* action(string $action, [string $k="]) = return actio using ROOT_ADDR

**Shortcuts class**

* static function render(string $render_file, [array $render_data]) 
* static function tpl_render(string $render_file, [array $render_data, bool $debug=false]) = render file using Smarty

*****************
*****************

#### MyDB
For mysql, based on PDO

* __construct([string $conf]) = $conf is config file address host, username, .. conf is ini fil default config file is HEAP."MyDB/config.ini"
* static function init() = load last created MyDB object or creat new with standart config
* setQueryDir(string $dir) = set folder address that contains sql query files
* load(string $sql, [array $params] ) = Load given $sql file if $mydb_object->setQueryDir($dir) given then loads $dir.$sql else loads HEAP."MyDB/".$sql $params for PDO prepear config
* function loadString(string $sql) = load $sql command
* run([array $params]) = $params for PDO execute
* get([PDO::FITCH_TYPE]) = Default type is PDO::FETCH_ASSOC 

**MyDB_SQLBox**
Extend your class with it and overload $sql associative array for using as __call by name __set by name overload $sql_noarg for __get as object property

*****************
*****************

#### Routing 
For route configuration */
* Routing::setControllersDir($ctrl_dir) = Set controllers location if this method not set then controllers taken from given path
* Routing::start( [mixed $route] ) = starts with $route file if $route is string, or files in $route array
  default config file is HEAP."Absolute_routing/route.xml"
 * route file {varname} 
 * {+varname} not add into pathe array make $varname global varable
 * {-varname} not add into path array 
 * ``` <varname> ``` make regexp for varname 

*****************
*****************

#### Smarty 
  Template engine 
  Default template dir is TPL
  Default configuration and cahe dir
  is HEAP/LIBDATA/Smarty/
  For more about Smarty visit 
  [Smarty official website](http://www.smarty.net) 

*****************
*****************

#### Reg
  Cache alternative - super static varables for every function 
* Reg::set(string $key, mixed $value ,[int $life_time]) = Serialize and save value. If $time not set value time infinit(8).
* Reg::get(string $key) = Unserialize and return saved value If $life_time small then time() or file not exists function ruturn false
* Reg::delete(string $key) = Delete $key varables saved value 

*****************
*****************

#### Translate
  Every language has own folder in HEAP.'Translate' folder
  file format is ini or php array, ```__GLOBAL__.ini``` or ```__GLOBAL__.php ``` file work for every page

*src/heap/am/word.ini*
```ini
[Ini file]
welcome = 'բարի գալուստ'
bye = 'ցտեսություն'
```
*src/heap/am/word.php*

```php
<?php return
[
'welcome'=>'բարի գալուստ',
'bye'=>'ցտեսություն'
];
```

* Translate construct(string $lang, [string $page='']) = return translate object for lang, loads ```__GLOBAL__``` if exists and $page if given
* function getPage(string $page) = load page from language folder

Language row get by property, getter return empty string if row not found
```php
<?php
$lang = new Translate('am');
echo $lang->welcome;
```

*****************
*****************
