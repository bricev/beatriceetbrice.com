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
                visibility: 'visible'
            })),

            state('stop', style({
                opacity: 0,
                visibility: 'hidden'
            })),

            transition('stop => start', [
                style({ visibility: 'visible' }),
                animate('500ms ease-out')
            ]),

            transition('start => stop', [ //       é_è
                style({ visibility: 'visible' }),
                animate('500ms ease-in', style({
                    opacity: 0
                })),
                animate('0s 500ms', style({
                    visibility: 'hidden'
                }))
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
