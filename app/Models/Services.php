<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;


    protected $table = 'services';

    protected $fillable = [
        'name','text', 'name_en','text_en'
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
            'title' => 'Услуги', // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('services.bshow'),
                'add'=> __('services.badd'),
                'edit'=> __('services.bedit'),
                'search'=> __('services.bsearch'),
                'clear'=> __('services.bclear'),
                'del'=> __('services.bdel'),

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
            'name' => __('services.fname'),
            'text' => __('services.ftext'),
            'name_en' => __('services.fname_en'),
            'text_en' => __('services.ftext_en'),
        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        return [
            'name',
            'text',
        ];
    }


    // Для построения формы
    public function form_bilder(){
        return [
            'name' => 'text',
            'text' => 'textarea',
            'name_en' => 'text',
            'text_en' => 'textarea',
        ];
    }
}
