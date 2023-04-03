# function getTree();

```php

    public function getTree($data)
    {
        $tree = [];
        $this->data = $data;
        foreach($data as $key => &$value){
            if(!$value['parent_id']){
                $tree[$key] = &$value;
            }else{
                $data[$value['parent_id']]['children'][$key] = &$value;
            }
        }
        return $tree;
    }



```
