<p align="center"><img src="https://m-finder.github.io/images/avatar.jpeg"></p>
<p align="center">
<img src="https://img.shields.io/badge/Author-m--finder-red">
<img src="https://img.shields.io/badge/Laravel-5.0-red">
<a href="https://packagist.org/packages/wu/giorgio-filter"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a>
</p>

## 关于 About Giorgio Filter
为你的 Laravel 应用添加一个简化的查询工具。
Add a simplified query tool to your Laravel application.

### 预览 Preview
![](https://repository-images.githubusercontent.com/721082370/0240b5fa-69e2-4bf0-89f2-fbed407c2b54)


### 安装 Install

引入扩展 
Require
```
composer require wu/giorgio-filter
```

在你的 Model 类中使用 Filter 
Use Filter in your Model class
```
use GiorgioFilter\Filters\Filter;
```


### 注意事项 Considerations
Filter 只能构建 `=` 条件的查询语句。如果要自定义复杂条件，请像下边代码示例一样自定义 Filter，最后将自定义 Filter 引入到 Model 中。

Filter can only build query with `=` conditions. If you want to customize complex conditions, please customize the Filter as shown in the code example below, and then import the customized Filter into the your Model.

示例 example：
```php
<?php

namespace App\Models;

use GiorgioFilter\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait UserFilter
{
    use Filter;

    protected function nameFilter($value): Builder
    {
        return $this->builder->where('name', 'like', '%' . $value . '%');
    }
}
```

### License

The Giorgio Socket is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
