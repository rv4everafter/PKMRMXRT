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
    public function getStatusButtonAttribute()
    {
        if ($this->id != auth()->id()) {
            switch ($this->active) {
                case 0:
                    if($this->sponsor_id == null)
                    return '<a href="'.route('admin.auth.admin.mark', [
                            $this,
                            1,
                        ]).'" class="dropdown-item">'.__('buttons.backend.access.admins.activate').'</a> ';
                    else
                    return '<a href="'.route('admin.auth.user.mark', [
                            $this,
                            1,
                        ]).'" class="dropdown-item">'.__('buttons.backend.access.users.activate').'</a> ';
                // No break

                case 1:
                    if($this->sponsor_id == null)
                    return '<a href="'.route('admin.auth.admin.mark', [
                            $this,
                            0,
                        ]).'" class="dropdown-item">'.__('buttons.backend.access.admins.deactivate').'</a> ';
                    else
                    return '<a href="'.route('admin.auth.user.mark', [
                            $this,
                            0,
                        ]).'" class="dropdown-item">'.__('buttons.backend.access.users.deactivate').'</a> ';
                // No break

                default:
                    return '';
                // No break
            }
        }

        return '';
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
}
