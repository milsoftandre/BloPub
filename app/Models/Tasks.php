<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Tasks extends Model
{
    use HasFactory;


    protected $table = 'tasks';

    protected $attributes = [
        'comment' => '',
        'rek' => '-',
    ];


    protected $fillable = [
        'name',
        'url',
        'text',
        'price',
        'end_date',
        'create_id',
        'make_id',
        'cat_id',
        'service_id',
        'group_id',
        'rek',
        'comment',
        'status',
        'cycle',
        'cycle_status',
        'date_cycle'
    ];





    /**
     * Настройки модели
     * @return array
     */
    public static function settings($full=0)
    {

        $arr =  [
            'pl' => 30, // Записей на странице
            'isEdit' => true, // Возможность редактировать
            'isDel' => true, // Возможность удаления
            'isAdd' => true, // Возможность добавления
            'isShow' => true,
            'isCheckbox' => true,
            'isExport' => true,
            'isImport' => true,
            'page' => 'index', // Название страницы
            'title' => __('tasks.title'), // Название страницы
            'buttons' => [ // Кнопки для вюхи
                'show'=> __('tasks.bshow'),
                'add'=> __('tasks.badd'),
                'edit'=> __('tasks.bedit'),
                'search'=> __('tasks.bsearch'),
                'clear'=> __('tasks.bclear'),
                'del'=> __('tasks.bdel'),

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
            'form' => [],
            'search' => [],
            'status' => [
                0 => __('tasks.status0'),
                1 => __('tasks.status1'),
                2 => __('tasks.status2'),
                3 => __('tasks.status3'),
                4 => __('tasks.status4'),
                5 => __('tasks.status5'),
                6 => __('tasks.status6'),
            ],
            'status_class' => [
                0 => 'badge-light-info',
                1 => 'badge-light-danger',
                2 => 'badge-light-primary',
                3 => 'badge-light-warning',
                4 => 'badge-light-info',
                5 => 'badge-light-success',
                6 => 'badge-light-success',
            ]

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
            'name' => __('tasks.name'),
           // 'url' => __('tasks.url'),
            'text' => __('tasks.text'),
            'price' => __('tasks.price'),
            'end_date' => __('tasks.end_date'),
            'create_id' => __('tasks.create_id'),
            'make_id' => __('tasks.make_id'),
            //'cat_id' => __('tasks.cat_id'),
            'service_id' => __('tasks.service_id'),
            'group_id' => __('tasks.group_id'),
            'rek' => __('tasks.rek'),
            'comment' => __('tasks.comment'),
            'status' => __('tasks.status'),
            'cycle' => __('tasks.cycle'),
            'date_cycle' => __('tasks.datecycle')

        ];
    }
//
//    public function messages()
//    {
//        return [
//            'name.required' => 'Укажите название задачи',
//            'body.required' => 'A message is required',
//        ];
//    }

    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {

        if (Auth::user()->type=='0'){
            return [
                'name',
                'create_id',
                'price',
                'end_date',
                'make_id',

            'rek',

                'status',
            ];
        }
        return [
            'name',
          //  'url',
            'price',
            'end_date',
            'make_id',
           // 'cat_id',
//            'service_id',
//            'group_id',
//            'rek',
//            'comment',
            'status',
        ];
    }


    // Для построения формы
    public function form_bilder(){

        if (Auth::user()->type=='1'){
            return [
                'name' => 'text',
               // 'url' => 'text',
                'text' => 'textarea',
                'price' => 'text',
                'end_date' => 'date',
                'make_id' => [
                    Employee::select('id', 'name')->whereIn('id',Emlinks::where('employees_id_to',Auth::user()->id)->pluck('employees_id', 'employees_id')->toArray())->pluck('name', 'id')->prepend(__('tasks.out'), '0')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid make_id',
                        'prompt' => self::settings()['attr']['make_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
//                'cat_id' => [
//                    Cat::select('id', 'name')->pluck('name', 'id')->prepend('Не указано', '0')->toArray(),
//                    [
//                        'class' => 'form-control form-select form-select-solid',
//                        'prompt' => self::settings()['attr']['cat_id'],
//                        'data-kt-select2' => 'true',
//                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
//                    ],
//                ],
                'service_id' => [
                    Services::select('id', 'name')->pluck('name', 'id')->prepend('Не указано', '0')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => self::settings()['attr']['service_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
                'group_id' => [
                    Group::select('id', 'name')->where('employees_id',Auth::user()->id)->pluck('name', 'id')->prepend(self::settings()['attr']['group_id'], '')->toArray(),
                    [
                        'class' => 'form-control form-select-solid form-select',
                        'prompt' => self::settings()['attr']['group_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
                'rek' => 'text',
                'comment' => 'textarea',
                'cycle' => 'text',

            ];
        }else {
        return [
            'name' => 'text',
            //'url' => 'text',
            'text' => 'textarea',
            'price' => 'text',
            'end_date' => 'date',
            'make_id' => [
                Employee::select('id', 'name')->pluck('name', 'id')->prepend(__('tasks.out'), '0')->toArray(),
                [
                    'class' => 'form-control form-select form-select-solid make_id',
                    'prompt' => self::settings()['attr']['make_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
//            'cat_id' => [
//                Cat::select('id', 'name')->pluck('name', 'id')->prepend('Не указано', '0')->toArray(),
//                [
//                    'class' => 'form-control form-select form-select-solid',
//                    'prompt' => self::settings()['attr']['cat_id'],
//                    'data-kt-select2' => 'true',
//                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
//                ],
//            ],
            'service_id' => [
                Services::select('id', 'name')->pluck('name', 'id')->prepend('Не указано', '0')->toArray(),
                [
                    'class' => 'form-control form-select form-select-solid',
                    'prompt' => self::settings()['attr']['service_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
            'group_id' => [
                Group::select('id', 'name')->pluck('name', 'id')->prepend('Не указано', '0')->toArray(),
                [
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => self::settings()['attr']['group_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
            'rek' => 'text',
            'comment' => 'textarea',
            'status' => [
                self::settings()['status'],
                [
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => self::settings()['attr']['status'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
            'cycle' => 'text',

        ];
        }
    }

    // Для построения формы
    public function search_bilder(){
        if (Auth::user()->type=='0') {
            return [
                'name' => 'text',
                'make_id' => [
                    Employee::select('id', 'name')->pluck('name', 'id')->prepend(__('tasks.out'), '0')->prepend('-', '')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => self::settings()['attr']['make_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
            'create_id' => [
                Employee::select('id', 'name')->where('type',1)->pluck('name', 'id')->prepend(self::settings()['attr']['create_id'], '')->prepend('Не указано', '0')->toArray(),
                [
                    'class' => 'form-control form-select form-select-solid',
                    'prompt' => self::settings()['attr']['create_id'],
                    'data-kt-select2' => 'true',
                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                ],
            ],
                'service_id' => [
                    Services::select('id', 'name')->pluck('name', 'id')->prepend(self::settings()['attr']['service_id'], '')->prepend('Не указано', '0')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => self::settings()['attr']['service_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
                'group_id' => [
                    Group::select('id', 'name')->where('employees_id', Auth::user()->id)->pluck('name', 'id')->prepend(self::settings()['attr']['group_id'], '')->prepend('Не указано', '0')->toArray(),
                    [
                        'class' => 'form-control form-select-solid form-select',
                        'prompt' => self::settings()['attr']['group_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],

            ];
        }else {
            return [
                'name' => 'text',
                'make_id' => [
                    Employee::select('id', 'name')->pluck('name', 'id')->prepend(__('tasks.out'), '0')->prepend('-', '')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => self::settings()['attr']['make_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
//            'cat_id' => [
//                Cat::select('id', 'name')->pluck('name', 'id')->prepend(self::settings()['attr']['cat_id'], '')->prepend('Не указано', '0')->toArray(),
//                [
//                    'class' => 'form-control form-select form-select-solid',
//                    'prompt' => self::settings()['attr']['cat_id'],
//                    'data-kt-select2' => 'true',
//                    'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
//                ],
//            ],
                'service_id' => [
                    Services::select('id', 'name')->pluck('name', 'id')->prepend(self::settings()['attr']['service_id'], '')->prepend('Не указано', '0')->toArray(),
                    [
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => self::settings()['attr']['service_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],
                'group_id' => [
                    Group::select('id', 'name')->where('employees_id',Auth::user()->id)->pluck('name', 'id')->prepend(self::settings()['attr']['group_id'], '')->prepend('Не указано', '0')->toArray(),
                    [
                        'class' => 'form-control form-select-solid form-select',
                        'prompt' => self::settings()['attr']['group_id'],
                        'data-kt-select2' => 'true',
                        'data-kt-data-dropdown-parent' => '#kt_menu_61484bf44f851'
                    ],
                ],

            ];
        }
    }

    public function groupid()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function serviceid()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function catid()
    {
        return $this->belongsTo(Cat::class, 'cat_id');
    }
    public function makeid()
    {
        return $this->belongsTo(Employee::class, 'make_id');
    }
    public function createid()
    {
        return $this->belongsTo(Employee::class, 'create_id');
    }
    public function makers()
    {
        return $this->belongsTo(Employee::class);
    }

    public function files()
    {
        return $this->hasMany(Taskfiles::class, 'task_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id', 'id');
    }

}
