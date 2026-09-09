<?php

namespace App\Enums;

enum EventStatus: string
{
    case Draft = 'draft';
    case Preparing = 'preparing';
    case Loading = 'loading';
    case Ready = 'ready';
    case Event = 'event';
    case Returning = 'returning';
    case Finished = 'finished';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Rascunho',
            self::Preparing => 'Preparação',
            self::Loading => 'Carregamento',
            self::Ready => 'Pronto para saída',
            self::Event => 'Em evento',
            self::Returning => 'Retorno',
            self::Finished => 'Finalizado',
            self::Cancelled => 'Cancelado',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::Draft => 'slate',
            self::Preparing => 'amber',
            self::Loading => 'sky',
            self::Ready => 'emerald',
            self::Event => 'violet',
            self::Returning => 'orange',
            self::Finished => 'zinc',
            self::Cancelled => 'rose',
        };
    }
}
