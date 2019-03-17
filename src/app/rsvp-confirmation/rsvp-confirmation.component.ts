import { Component, Input, OnInit, OnChanges, SimpleChange, SimpleChanges } from '@angular/core';
import {FormGroup, FormControl, FormArray} from '@angular/forms';
import { Rsvp } from '../rsvp/rsvp';

@Component({
    selector: 'app-rsvp-confirmation',
    templateUrl: './rsvp-confirmation.component.html',
    styleUrls: [
        '../../form.css',
        './rsvp-confirmation.component.css'
    ]
})
export class RsvpConfirmationComponent implements OnInit, OnChanges {

    @Input() rsvp: Rsvp;

    comingGuests = [];

    rsvpForm = new FormGroup({
        guests: new FormArray([]),
        needBabysitter: new FormControl(false),
        needDriver: new FormControl(false),
        hasAllergy: new FormControl(false),
        favorite60sTube: new FormControl(''),
        favorite70sTube: new FormControl(''),
        favorite80sTube: new FormControl(''),
        favoriteContemporaryTube: new FormControl(''),
    });

    constructor() {}

    ngOnInit() {}

    ngOnChanges(changes: SimpleChanges) {
        const change: SimpleChange = changes.rsvp;
        if (null === change.currentValue) {
            return;
        }

        let rsvp: Rsvp = change.currentValue;

        let comingGuest = [];
        if (null !== rsvp.rsvp) {
            for (let i=0; i<rsvp.rsvp.comingGuests.length; i++) {
                comingGuest.push(rsvp.rsvp.comingGuests[i].name);
            }
        }

        let guests = new FormArray([]);
        for (let j=0; j<rsvp.group.guests.length; j++) {
            guests.push(
                new FormControl(comingGuest.indexOf(rsvp.group.guests[j].name) >= 0)
            );
            this.comingGuests.push(rsvp.group.guests[j].name);
        }
        this.rsvpForm.setControl('guests', guests);

        if (null === rsvp.rsvp) {
            return;
        }

        this.rsvpForm.controls['needBabysitter'].setValue(rsvp.rsvp.needBabysitter);
        this.rsvpForm.controls['needDriver'].setValue(rsvp.rsvp.needDriver);
        this.rsvpForm.controls['hasAllergy'].setValue(rsvp.rsvp.hasAllergy);
        this.rsvpForm.controls['favorite60sTube'].setValue(rsvp.rsvp.favorite60sTube);
        this.rsvpForm.controls['favorite70sTube'].setValue(rsvp.rsvp.favorite70sTube);
        this.rsvpForm.controls['favorite80sTube'].setValue(rsvp.rsvp.favorite80sTube);
        this.rsvpForm.controls['favoriteContemporaryTube'].setValue(rsvp.rsvp.favoriteContemporaryTube);
    }
}
