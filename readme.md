## 简介

Easy sdk 开发辅助扩展包，目前主要为自定义sdk组件扩展包提供独立的测试环境

[![Latest Stable Version](https://poser.pugx.org/f-oris/easy-sdk-develop/v)](//packagist.org/packages/f-oris/easy-sdk-develop) [![Total Downloads](https://poser.pugx.org/f-oris/easy-sdk-develop/downloads)](//packagist.org/packages/f-oris/easy-sdk-develop) [![Latest Unstable Version](https://poser.pugx.org/f-oris/easy-sdk-develop/v/unstable)](//packagist.org/packages/f-oris/easy-sdk-develop) [![License](https://poser.pugx.org/f-oris/easy-sdk-develop/license)](//packagist.org/packages/f-oris/easy-sdk-develop)

## 功能

- [x] 为自定义sdk组件扩展包提供独立的测试环境
- [x] 增加ide-helper相应指令，方便开发人员进行联调开发

## 安装

通过composer引入扩展包

```bash
composer require f-oris/easy-sdk-develop --dev
```

## 使用

#### 模拟sdk运行环境

模拟sdk运行环境，获取app实例，在实际组件包测试中，可通过该app实例测试加载自定义组件包，获取组件实例并进行组件测试

```php
<?php

namespace Foris\Easy\Sdk\Develop\Tests;

/**
 * Class TestCase
 */
class TestCase extends \Foris\Easy\Sdk\Develop\TestCase
{
    /**
     * Test get demo application instance.
     */
    public function testGetDemoApplicationInstance()
    {
        $this->assertInstanceOf('Foris\Demo\Sdk\Application', $this->app());
    }
}

```

## License

MIT License

Copyright (c) 2019-present F.oris <us@f-oris.me>

