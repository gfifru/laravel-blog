<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DiggingDeeperController extends Controller
{
    public function collections()
    {
        $result = [];

        /**
         * @var Collection $eloquentCollection
         */
        $eloquentCollection = BlogPost::withTrashed()->get();

//        dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        /**
         * @var \Illuminate\Support\Collection $collection
         */
        $collection = collect($eloquentCollection->toArray());

//        dd(
//            __METHOD__,
//            get_class($eloquentCollection),
//            get_class($collection),
//            $collection
//        );

//        $result['first'] = $collection->first(); // первый элемент
//        $result['last'] = $collection->last(); // последний элемент

        /**
         *  Все статьи, категория которых равна 10
         */
//        $result['where']['data'] = $collection
//            ->where('category_id', 10) // выборка
//            ->values() // взять только значения
//            ->keyBy('id'); // ключи станут id
//            ->sortBy('id', 1, 'ASC'); // сортировка

//        $result['where']['count'] = $result['where']['data']->count(); // количество статей в коллекции
//        $result['where']['isEmpty'] = $result['where']['data']->isEmpty(); // пустая коллекция?
//        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty(); // не пустая коллекция?

//        $result['where_first'] = $collection
//            ->firstWhere('created_at', '>', '2021-01-01');

//        $result['map']['all'] = $collection->map(function (array $item) {
//            $newItem = new \stdClass();
//            $newItem->item_id = $item['id'];
//            $newItem->item_name = $item['title'];
//            $newItem->exists = is_null($item['deleted_at']);
//            return $newItem;
//        });
//        $result['map']['not_exists'] = $result['map']['all']
//            ->where('exists', '=', false)
//            ->values()
//            ->keyBy('item_id');

        $collection->transform(function (array $item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });

        /*
        $newItem = new \stdClass();
        $newItem->id = 999;

        $newItem2 = new \stdClass();
        $newItem2->id = 888;

        dd($newItem, $newItem2);

        // поставить элемент в начало
        $newItemFirst = $collection->prepend($newItem)->first();
        // поставить элемент в конец
        $newItemLast = $collection->push($newItem2)->last();
        // забрать элемент с ключом 1
        $pulledItem = $collection->pull(1);
        dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));
        */

        // Фильтрация

        // Найти пост написанный в пятницу и 11 числа
        /*
        $filtered = $collection->filter(function ($item) {
            $byDay = $item->created_at->isFriday();
            $byDate = $item->created_at->day == 11;
            $result = $byDay && $byDate;
            return $result;
        });
        dd($filtered);
        */

        // Сортировка
        /*
        $sortedSimpleCollection = collect([5,2,1,3,4])->sort();
        $sortedDescCollection = $collection->sortByDesc('created_at');
        $sortedAscCollection = $collection->sortBy('item_id');

        dd(compact('sortedSimpleCollection', 'sortedDescCollection', 'sortedAscCollection'));
        */

    }
}
