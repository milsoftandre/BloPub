<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;
    protected $table = 'cat';

    protected $fillable = [
        'name','name_en'
    ];


    protected $hidden = [
        'password',
        'remember_token',
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
                'show'=> __('cat.bshow'),
                'add'=> __('cat.badd'),
                'edit'=> __('cat.bedit'),
                'search'=> __('cat.bsearch'),
                'clear'=> __('cat.bclear'),
                'del'=> __('cat.bdel'),

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
            'name' => __('cat.fname'),
            'name_en' => __('cat.fname_en'),
        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        return [
            'name',
            'name_en',
        ];
    }


    // Для построения формы
    public function form_bilder(){
        return [
            'name' => 'text',
            'name_en' => 'text',
        ];
    }
}
