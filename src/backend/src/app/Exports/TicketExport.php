<?php

namespace App\Exports;

use App\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Query\Expression;

class TicketExport implements FromQuery, WithHeadings
{
    protected $week;
    protected $invalidos;
    protected $headings = [
        'id',
        'user_id',
        'user_email',
        'numeroTicket',
        'nombre',
        'apellido',
        'foto',
        'estado_id',
        'estado',
        'telefono',
        'tiempo',
        'movimientos',
        'fingerprint',
        'mes',
        'dia',
        'ticket',
        'status',
        'statusDesc',
        'rule',
        'regexData',
        'productos',
        'numProductos',
        'importe',
        'processTime',
        'submitDate',
        'updateDate',
        'semana',
        'valido',
        'submitDate_MexicoCity'
    ];

    function __construct($week,$invalidos=0)
    {
        $this->week=$week;
        $this->invalidos=$invalidos;
    }




    public function query()
    {
        $select= Ticket::select([
                'ticket.id as id',
                'users.id as user_id',
                'users.email as email',
                'ticket.numero as numero',
                'ticket.nombre',
                'ticket.apellido',
                'ticket.foto',
                'ticket.estado_id',
                'cat_estado.name as estado',
                'ticket.telefono',
                'game_t',
                'game_m',
                'fingerprint',
                'mes',
                'dia',
                'path',
                'status_id',
                'status_desc',
                'rule_id',
                'data',
                'products_find',
                'product',
                'import',
                'process_time',
                'ticket.created_at',
                'ticket.updated_at',
                'week',
                'submited',
                new Expression("CONVERT_TZ(ticket.created_at, 'UTC', 'America/Mexico_City')")
                ])
            ->leftJoin("users","users.id","=","ticket.user_id")
            ->leftJoin("cat_estado","cat_estado.id","=","ticket.estado_id")
            ->leftJoin("cat_tienda","cat_tienda.id","=","ticket.tienda_id")
            ->where(["users.activo"=>1]);
        if(!$this->invalidos){
            $select->where([
                //'week'=>$this->week,
                'submited'=>1
                ]);
            }
        return $select;
    }

    public function headings() : array
    {
        return $this->headings;
    }
}
