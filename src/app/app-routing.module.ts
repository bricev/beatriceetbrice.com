import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { LocationComponent } from './location/location.component';
import { HousingComponent } from './housing/housing.component';
import { PlanningComponent } from './planning/planning.component';
import { RsvpComponent } from './rsvp/rsvp.component';
import { HoneymoonComponent } from './honeymoon/honeymoon.component';

const routes: Routes = [
    { path: 'location',  component: LocationComponent },
    { path: 'housing',   component: HousingComponent },
    { path: 'planning',  component: PlanningComponent },
    { path: 'rsvp',      component: RsvpComponent },
    { path: 'honeymoon', component: HoneymoonComponent },
    { path: '**',        component: HomeComponent, pathMatch: 'full' },
];

@NgModule({
    imports: [ RouterModule.forRoot(routes) ],
    exports: [ RouterModule ]
})

export class AppRoutingModule {}
