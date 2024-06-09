<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name', 'email', 'password', 'type','employees_id','balance',
'typeuser',
'lname',
'dir',
'inn',
'ogrn',
'uadres',
'rs',
'bname',
'badres',
'bkor',
'bic',
        'file',
        'kpp',
        'position',
        'swift',
        'tel',
        'code',
        'online_user',
        'status',
        'lang',
        'ip',
        'lastdatecode',
        'token',
        'apiips',
        'partner_id',
        'prec',
        'promo'

    ];




    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Настройки модели
     * @return array
     */
    public static function settings($full=0,$type=0)
    {

        $title = __('employee.title1');

        if((strpos("-".Route::currentRouteName(),"hand"))){
            $title = __('employee.title2');
        }
        if((strpos("-".Route::currentRouteName(),"client"))){
            $title = (Auth::user()->type=='0')?__('employee.ad'):__('employee.title3');
        }

        $arr = [
            'pl' => 30, // Записей на странице
            'isEdit' => true, // Возможность редактировать
            'isDel' => true, // Возможность удаления
            'isAdd' => true, // Возможность добавления
            'isShow' => false,
            'isCheckbox' => false,
            'isExport' => true,
            'isImport' => true,
            'page' => 'index', // Название страницы
            'title' => $title, // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('employee.bshow'),
                'add'=> __('employee.badd'),
                'edit'=> __('employee.bedit'),
                'search'=> __('employee.bsearch'),
                'clear'=> __('employee.bclear'),
                'del'=> __('employee.bdel'),

            ],
            'search_settings' => [  // Настройки для поиска
                'like' => [ // Поля которые используем с неточным совпадением
                    'name',
                    'pwd',
                    'email',
                    'tel',
                    'rules',
                    'type',
                    'created_at',
                    'bdate',
                    'adres'
                ],
                'range' => [ // Поля которые используем с периодом от-до
                    'oklad'
                ]
            ],
            'typeuser' => [
                0 => 'Физические лица',
                3 => 'Самозанятый',
                4 => 'Нерезидент',
                1 => 'ИП',
                2 => 'ООО'
            ],
            'table' => self::showInTable(),
            'table_client' => self::showInTable(1),
            'table_agent' => self::showInTable(3),
            'attr' => self::attr(),
            'form' => []

        ];

        if($full==2){
            $arr['search'] = self::search_bilder();
        }elseif($full){
            $arr['form'] = self::form_bilder($type);
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
            'name' => __('employee.fname'),
            'pwd' => __('employee.fpwd'),
            'email' => __('employee.femail'),
            'tel' => __('employee.tel'),
            'created_at' => __('employee.fcreated_at'),
            'password' => __('employee.fpassword'),

            'typeuser' => __('employee.typeuser'),
            'lname' => __('employee.lname'),
            'dir' => __('employee.dir'),
            'inn' => __('employee.inn'),
            'ogrn' => __('employee.ogrn'),
            'uadres' => __('employee.uadres'),
            'rs' => __('employee.rs'),
            'bname' => __('employee.bname'),
            'badres' => __('employee.badres'),
            'bkor' => __('employee.bkor'),
            'bic' => __('employee.bic'),
            'kpp' => __('employee.kpp'),
            'swift' => __('employee.swift'),
            'position' => __('employee.position'),
            'apiips' => __('employee.apiips'),
            'partner_id' => __('employee.partner_id'),
            'prec' => __('employee.prec'),
            'promo' => __('employee.promo')
        ];
    }


    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable($type=0)
    {
        if (Auth::user()->type=='1' && $type==1){
            return [
                'name',
                'email',
                'position',
                'created_at'
            ];
        }

        if (Auth::user()->type=='0' && $type==3){
            return [
                'name',
                'email',
                'position',
                'prec',
                'promo',
                'created_at',

            ];
        }

        return [
            'name',
            'email',
            'created_at'
        ];
    }


    // Для построения формы
    public function form_bilder($type=0){
        if($type==0){
        return [
            'name' => 'text',
            'email' => 'text',
            'tel' => 'text',


            'typeuser' => [
                self::settings()['typeuser'],
                [
                    'class' => 'form-control form-select-solid form-select typeuser',
                    'prompt' => self::settings()['attr']['typeuser'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],

            'lname' => 'text',
            'dir' => 'text',
            'inn' => 'text',
            'ogrn' => 'text',
            'uadres' => 'text',
            'rs' => 'text',
            'bname' => 'text',
            'badres' => 'text',
            'bkor' => 'text',
            'bic' => 'text',
            'kpp' => 'text',
            'swift' => 'text',
            'password' => 'password',
        ];
        }else {
            if($type==3){
                return [
                    'name' => 'text',
                    'email' => 'text',
                    'tel' => 'text',
                    'position' => 'text',
                    'prec' => 'text',
                    'promo' => 'text',
                    'password' => 'password',

                ];
            }
            return [
                'name' => 'text',
                'email' => 'text',
                'tel' => 'text',
                'position' => 'text',
                'password' => 'password',

            ];
        }
    }
    public function search_bilder(){
        return [];
    }

}
