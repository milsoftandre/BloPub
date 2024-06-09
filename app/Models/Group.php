<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'group';

    protected $fillable = [
        'name', 'employees_id'
    ];





    /**
     * Настройки модели
     * @return array
     */
    public static function settings()
    {

        return [
            'pl' => 30, // Записей на странице
            'isEdit' => true, // Возможность редактировать
            'isDel' => true, // Возможность удаления
            'isAdd' => true, // Возможность добавления
            'isShow' => false,
            'isCheckbox' => false,
            'isExport' => true,
            'isImport' => true,
            'page' => 'index', // Название страницы
            'title' => __('cat.name'), // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('group.bshow'),
                'add'=> __('group.badd'),
                'edit'=> __('group.bedit'),
                'search'=> __('group.bsearch'),
                'clear'=> __('group.bclear'),
                'del'=> __('group.bdel'),

            ],
            'search_settings' => [  // Настройки для поиска
                'like' => [ // Поля которые используем с неточным совпадением
                    'name',

                ],
                'range' => [ // Поля которые используем с периодом от-до

                ]
            ],
            'table' => self::showInTable(),
            'attr' => self::attr(),
            'form' => self::form_bilder()

        ];
    }

    /**
     * Поля и их атрибуты
     * @return array
     */
    public function attr()
    {
        return [
            'name' => __('group.fname'),

        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        return [
            'name',

        ];
    }


    // Для построения формы
    public function form_bilder(){
        return [
            'name' => 'text',

        ];
    }

    public function tasks()
    {
        return $this->belongsTo(Tasks::class, 'group_id');
    }
}
