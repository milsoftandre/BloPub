<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;
    protected $table = 'templates';

    protected $fillable = [
        'name','text'
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
            'isDel' => false, // Возможность удаления
            'isAdd' => true, // Возможность добавления
            'isShow' => false,
            'isCheckbox' => false,
            'isExport' => true,
            'isImport' => true,
            'page' => 'index', // Название страницы
            'title' => __('templates.name'), // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('templates.bshow'),
                'add'=> __('templates.badd'),
                'edit'=> __('templates.bedit'),
                'search'=> __('templates.bsearch'),
                'clear'=> __('templates.bclear'),
                'del'=> __('templates.bdel'),

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
            'name' => __('templates.fname'),
            'text' => __('templates.ftext'),
        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        return [
            'name',
          //  'text',
        ];
    }


    // Для построения формы
    public function form_bilder(){
        return [
            'name' => 'text',
            'text' => 'textarea',
        ];
    }
}
