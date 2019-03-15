import { Component, Input, OnInit } from '@angular/core';
import { Rsvp } from '../rsvp/rsvp';

@Component({
    selector: 'app-rsvp-confirmation',
    templateUrl: './rsvp-confirmation.component.html',
    styleUrls: [
        '../../form.css',
        './rsvp-confirmation.component.css'
    ]
})
export class RsvpConfirmationComponent implements OnInit {

    @Input() rsvp: Rsvp;

    constructor() {}

    ngOnInit() {}
}
