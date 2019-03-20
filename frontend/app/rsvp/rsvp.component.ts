import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { trigger, state, style, animate, transition } from '@angular/animations';

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

            transition('show => hide', [
                style({ display: 'block' }),
                animate('500ms ease-in')
            ]),

            transition('hide => show', [
                style({ display: 'block' }),
                animate('500ms 500ms ease-out')
            ])
        ])
    ]
})
export class RsvpComponent implements OnInit {

    @ViewChild('codeInput') field: ElementRef;

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
            }, error => {
                if ('undefined' === typeof error.status || error.status >= 500 || error.status === 0) {
                    alert(
                        'Désolé, un problème est survenu. \n' +
                        'Merci d\'essayer plus tard et/ou de nous prévenir à l\'adresse mariage@beatriceetbrice.com.'
                    );

                } else {
                    alert(
                        'Désolé, votre code n\'a pas été reconnu. \n' +
                        'Merci d\'essayer à nouveau...'
                    );

                    this.field.nativeElement.select();
                }
            });
    }

    ngOnInit() {}
}
