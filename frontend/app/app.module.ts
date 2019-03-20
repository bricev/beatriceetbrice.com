import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoaderInterceptorService } from './loader/loader-interceptor.service';

import { NavigationComponent } from './navigation/navigation.component';
import { HomeComponent } from './home/home.component';
import { LocationComponent } from './location/location.component';
import { HousingComponent } from './housing/housing.component';
import { PlanningComponent } from './planning/planning.component';
import { HoneymoonComponent } from './honeymoon/honeymoon.component';
import { RsvpComponent } from './rsvp/rsvp.component';
import { RsvpFormComponent } from './rsvp-form/rsvp-form.component';
import { LoaderComponent } from './loader/loader.component';
import { RsvpValidationComponent } from './rsvp-validation/rsvp-validation.component';

@NgModule({
    declarations: [
        AppComponent,
        NavigationComponent,
        HomeComponent,
        LocationComponent,
        HousingComponent,
        PlanningComponent,
        HoneymoonComponent,
        RsvpComponent,
        RsvpFormComponent,
        LoaderComponent,
        RsvpValidationComponent,
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        AppRoutingModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule
    ],
    providers: [{
        provide: HTTP_INTERCEPTORS,
        useClass: LoaderInterceptorService,
        multi: true
    }],
    bootstrap: [ AppComponent ]
})

export class AppModule {}
