<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Finance extends Model
{
    use HasFactory;
    protected $table = 'finance';

    protected $fillable = [
        'name', 'price','type', 'employees_id'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Настройки модели
     * @return array
     */
    public static function settings($full=0)
    {

        $arr =  [
            'pl' => 30, // Записей на странице
            'isEdit' => false, // Возможность редактировать
            'isDel' => false, // Возможность удаления
            'isAdd' => (Auth::user()->type=='0')?true:false, // Возможность добавления
            'isShow' => false,
            'isCheckbox' => false,
            'isExport' => true,
            'isImport' => true,
            'page' => 'index', // Название страницы
            'title' => __('finance.name'), // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('finance.bshow'),
                'add'=> __('finance.badd'),
                'edit'=> __('finance.bedit'),
                'search'=> __('finance.bsearch'),
                'clear'=> __('finance.bclear'),
                'del'=> __('finance.bdel'),

            ],
            'search_settings' => [  // Настройки для поиска
                'like' => [ // Поля которые используем с неточным совпадением
                    'name',

                ],
                'range' => [ // Поля которые используем с периодом от-до

                ]
            ],
            'type' => [
                0 => __('finance.type0'),
                1 => __('finance.type1'),

            ],
            'type_class' => [
                0 => 'badge-light-info',
                1 => 'badge-light-danger',

            ],
            'table' => self::showInTable(),
            'attr' => self::attr(),
            'form' => [],
            'search' => []


        ];
        if($full==2){
            $arr['search'] = self::search_bilder();
        }elseif($full){
            $arr['form'] = self::form_bilder();
        }
        return $arr;

    }

    /**
     * Поля и их атрибуты
     * @return array
     */
    public function attr()
    {
        return [
            'name' => __('finance.fname'),
            'price' => __('finance.fprice'),
            'type' => __('finance.ftype'),
            'employees_id' => __('finance.employees_id'),
        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        return [
            'name',
            'price',
            'type',
            'employees_id'
        ];
    }


    // Для построения формы
    public function form_bilder(){
        return [
            'name' => 'text',
            'price' => 'text',
            'type' => [
                self::settings()['type'],
                [
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => self::settings()['attr']['type'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
            'employees_id' => [
                Employee::select('id', 'name')->whereIn('type', [1,2])->pluck('name', 'id')->prepend(self::settings()['attr']['employees_id'], '')->toArray(),
                [
                    'class' => 'form-control form-select form-select-solid',
                    'prompt' => self::settings()['attr']['employees_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],

        ];
    }
    // Для построения формы
    public function search_bilder(){
        return [
            'name' => 'text',
            'type' => [
                self::settings()['type'],
                [
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => self::settings()['attr']['type'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
            'employees_id' => [
                Employee::select('id', 'name')->whereIn('type', [1,2])->pluck('name', 'id')->prepend(self::settings()['attr']['employees_id'], '')->toArray(),
                [
                    'class' => 'form-control form-select form-select-solid',
                    'prompt' => self::settings()['attr']['employees_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],

        ];
    }
    public function employeesid()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }
}
