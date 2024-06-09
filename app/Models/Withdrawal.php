<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Withdrawal extends Model
{
    use HasFactory;
    protected $table = 'withdrawal';

    protected $fillable = [
        'text', 'price','status', 'user_id'
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
            'isDel' => true, // Возможность удаления
            'isAdd' => true, // Возможность добавления
            'isShow' => false,
            'isCheckbox' => false,
            'isExport' => true,
            'isImport' => true,
            'page' => 'index', // Название страницы
            'title' => __('withdrawal.name'), // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('withdrawal.bshow'),
                'add'=> __('withdrawal.badd'),
                'edit'=> __('withdrawal.bedit'),
                'search'=> __('withdrawal.bsearch'),
                'clear'=> __('withdrawal.bclear'),
                'del'=> __('withdrawal.bdel'),

            ],
            'search_settings' => [  // Настройки для поиска
                'like' => [ // Поля которые используем с неточным совпадением
                    'name',

                ],
                'range' => [ // Поля которые используем с периодом от-до

                ]
            ],
            'status' => [
                0 => __('withdrawal.type0'),
                1 => __('withdrawal.type1'),

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
            'text' => __('withdrawal.fname'),
            'price' => __('withdrawal.fprice'),
            'status' => __('withdrawal.ftype'),
            'user_id' => __('withdrawal.employees_id'),
        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        if(Auth::user()->type==0) {
            return [
                'text',
                'price',
                'status',
                'user_id'
            ];
        }else {
            return [
                'text',
                'price',
                'status',
                'user_id'
            ];
        }
    }


    // Для построения формы
    public function form_bilder(){
        if(Auth::user()->type==0) {
        return [
            'text' => 'text',
            'price' => 'text',
            'status' => [
                self::settings()['status'],
                [
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => self::settings()['attr']['status'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
            'user_id' => [
                Employee::select('id', 'name')->whereIn('type', [1,2])->pluck('name', 'id')->prepend(self::settings()['attr']['user_id'], '')->toArray(),
                [
                    'class' => 'form-control form-select form-select-solid',
                    'prompt' => self::settings()['attr']['user_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],

        ];
            }else {
            return [
                'price' => 'text'
                ];
        }
    }
    // Для построения формы
    public function search_bilder(){
        if(Auth::user()->type==0) {
            return [
                'text' => 'text',
                'status' => [
                    self::settings()['status'],
                    [
                        'class' => 'form-control form-select-solid form-select',
                        'prompt' => self::settings()['attr']['status'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
                'user_id' => [
                    Employee::select('id', 'name')->whereIn('type', [1, 2])->pluck('name', 'id')->prepend(self::settings()['attr']['user_id'], '')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => self::settings()['attr']['user_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],

            ];
        }else {
            return [
                'text' => 'text',
                'status' => [
                    self::settings()['status'],
                    [
                        'class' => 'form-control form-select-solid form-select',
                        'prompt' => self::settings()['attr']['status'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],


            ];
        }
    }
    public function userid()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
