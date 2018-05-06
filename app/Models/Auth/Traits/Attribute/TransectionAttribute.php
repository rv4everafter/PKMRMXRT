<?php

namespace App\Models\Auth\Traits\Attribute;

/**
 * Trait TransectionAttribute.
 */
trait TransectionAttribute
{
     /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.auth.commission.completed', $this).'" class="btn btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.view').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getCompleteButtonAttribute()
    {
            return '<a href="'.route('admin.auth.commission.payment', $this).'" class="btn btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
    }
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '
    	<div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
		  '.$this->show_button.'
		  '.$this->complete_button.'
		</div>';
    }
    
    public function getTdsAmount()
    {
        return '<div class="btn-group btn-group-sm" role="group" aria-label="User Actions">'.($this->id).'</div>';
    }
}
