```php
class Menu
{

    public function createTree($arr)
    {
        $parents_array = [];
        foreach($arr as $key => $value){
            $parents_array[$value['parent_id']][$value['id']] = $value;
        }
        
        return $this->generateElemTree($parents_array[0], $parents_array);
    }
    public function generateElemTree($treeElem, $parents_array)
    {
        foreach($treeElem as $key => $value){
            if(!isset($value['children'])){
                $treeElem[$key]['children'] = [];
            }
            if(array_key_exists($key, $parents_array)){
                $treeElem[$key]['children'] = $parents_array[$key];
                $this->generateElemTree($treeElem[$key]['children'], $parents_array);
            }
        }
        return $treeElem;
    }
    public function getParentArray()
    {
        return $this->parent_array;
    }

}
```
