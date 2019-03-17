import { Component, OnInit } from '@angular/core';
import {
    trigger,
    state,
    style,
    animate,
    transition
} from '@angular/animations';

import { Rsvp } from './rsvp';
import { RsvpService } from './rsvp.service';

@Component({
    selector: 'app-rsvp',
    templateUrl: './rsvp.component.html',
    providers: [ RsvpService ],
    styleUrls: [
        '../../form.css',
        './rsvp.component.css'
    ],
    animations: [
        trigger('code', [
            state('show', style({
                opacity: 1,
                display: 'block'
            })),

            state('hide', style({
                opacity: 0,
                display: 'none'
            })),

            transition('show => hide', [ //       é_è
                style({ display: 'block' }),
                animate('500ms ease-in')
            ])
        ]),
        trigger('confirmation', [
            state('show', style({
                opacity: 1,
                display: 'block'
            })),

            state('hide', style({
                opacity: 0,
                display: 'none'
            })),

            transition('hide => show', [
                style({ display: 'block' }),
                animate('500ms 600ms ease-out')
            ])
        ])
    ]
})
export class RsvpComponent implements OnInit {

    rsvp: Rsvp = null;
    code: string;

    constructor(
        private rsvpService: RsvpService
    ) {}

    checkCode() {
        this.rsvpService
            .getRsvp(this.code)
            .subscribe(rsvp => {
                this.rsvp = rsvp as Rsvp;
            });
    }

    ngOnInit() {}
}
