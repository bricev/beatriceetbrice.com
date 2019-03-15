import { Component, OnInit } from '@angular/core';
import { Rsvp } from './rsvp';
import { RsvpService } from './rsvp.service';

@Component({
    selector: 'app-rsvp',
    templateUrl: './rsvp.component.html',
    providers: [ RsvpService ],
    styleUrls: [
        '../../form.css',
        './rsvp.component.css'
    ]
})
export class RsvpComponent implements OnInit {

    rsvp: Rsvp = null;
    code: string;

    constructor(
        private rsvpService: RsvpService
    ) {}

    checkCode() {
        console.log('COOODEE',this.code);
        this.rsvpService
            .getRsvp(this.code)
            .subscribe(rsvp => {
                this.rsvp = rsvp as Rsvp;
            });
    }

    ngOnInit() {}
}
