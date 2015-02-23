<?php

namespace app\components;

use yii\widgets\ListView;

class ReversibleListView extends ListView {
    /**
     * @var bool Whether the items should be rendered in reverse order
     * The reverse ordering only applies to the current page. Pagination logic
     * still follows the original ordering. This is analogous to vertically
     * flipping every page of a book.
     */
    public $reverseSort = false;

    /**
     * Renders all data models.
     * @return string the rendering result
     */
    public function renderItems()
    {
        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        if ($this->reverseSort === true) {
            $models = array_reverse($models);
        }
        foreach (array_values($models) as $index => $model) {
            $rows[] = $this->renderItem($model, $keys[$index], $index);
        }

        return implode($this->separator, $rows);
    }

}
