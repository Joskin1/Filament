<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserInfolist extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    #[Layout('layouts.app')]
    public User $user;
    public function mount(User $user)
    {
        $this->user = $user;
    }
   
    public function userInfolist(InfoList $infolist): Infolist
{
   
    return $infolist
    ->record($this->user)
        ->schema([
            TextEntry::make('name'),
            TextEntry::make('email'),
            // ...
        ]);
}
    public function render()
    {
        return view('livewire.user-info-list');
    }
}
