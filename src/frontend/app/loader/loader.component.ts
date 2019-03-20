import { Component, Renderer2, OnInit, OnDestroy } from '@angular/core';
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
        private loaderService: LoaderService,
        private renderer: Renderer2
    ) {}

    ngOnInit() {
        this.subscription = this.loaderService
            .state
            .subscribe((loadingState: LoaderState) => this.toggleLoader(loadingState.loading));
    }

    ngOnDestroy() {
        this.subscription.unsubscribe();
    }

    toggleLoader(start) {
        start ? this.startLoader() : this.stopLoader();
    }

    startLoader() {
        this.loading = true;
        this.renderer.addClass(document.body, 'loading');
        for (const input of [].slice.call(document.querySelectorAll('form .field input, form button'))) {
            this.renderer.setAttribute(input, 'disabled', 'disabled');
        }
    }

    stopLoader() {
        this.loading = false;
        this.renderer.removeClass(document.body, 'loading');
        for (const input of [].slice.call(document.querySelectorAll('form .field input, form button'))) {
            this.renderer.removeAttribute(input, 'disabled');
        }
    }
}
