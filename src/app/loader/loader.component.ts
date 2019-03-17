import { Component, OnInit, OnDestroy } from '@angular/core';
import {
    trigger,
    state,
    style,
    animate,
    transition
} from '@angular/animations';

import { Subscription } from 'rxjs';
import { LoaderService } from './loader.service';
import { LoaderState } from './loader';

@Component({
    selector: 'app-loader',
    templateUrl: './loader.component.html',
    styleUrls: ['./loader.component.css'],
    animations: [
        trigger('startStop', [
            state('start', style({
                opacity: .5,
                display: 'block'
            })),

            state('stop', style({
                opacity: 0,
                display: 'none'
            })),

            transition('stop => start', [
                style({ display: 'block' }),
                animate('500ms ease-out')
            ]),

            transition('start => stop', [
                style({ display: 'block' }),
                animate('500ms ease-in')
            ])
        ])
    ]
})
export class LoaderComponent implements OnInit, OnDestroy {

    loading = false;

    private subscription: Subscription;

    constructor(
        private loaderService: LoaderService
    ) {}

    ngOnInit() {
        this.subscription = this.loaderService
            .state
            .subscribe((loadingState: LoaderState) => {
                this.loading = loadingState.loading;
            });
    }

    ngOnDestroy() {
        this.subscription.unsubscribe();
    }
}
