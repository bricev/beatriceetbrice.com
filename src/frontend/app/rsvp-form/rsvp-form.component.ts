import { Component, Input, OnInit, OnChanges, SimpleChange } from '@angular/core';
import { FormGroup, FormControl, FormArray } from '@angular/forms';
import { trigger, state, style, animate, transition } from '@angular/animations';
import { Confirmation, Rsvp } from '../rsvp/rsvp';
import { RsvpService } from '../rsvp/rsvp.service';

@Component({
    selector: 'app-rsvp-form',
    templateUrl: './rsvp-form.component.html',
    styleUrls: [
        '../../form.css',
        './rsvp-form.component.css'
    ],
    animations: [
        trigger('validation', [
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
export class RsvpFormComponent implements OnInit, OnChanges {

    @Input() rsvp: Rsvp;

    guests = [];
    decline = false;
    submitted = false;

    rsvpForm = new FormGroup({
        identifier: new FormControl(''),
        guests: new FormArray([]),
        needBabysitter: new FormControl(false),
        needDriver: new FormControl(false),
        hasAllergy: new FormControl(false),
        favorite60sTube: new FormControl(''),
        favorite70sTube: new FormControl(''),
        favorite80sTube: new FormControl(''),
        favoriteContemporaryTube: new FormControl(''),
    });

    constructor(
        private rsvpService: RsvpService
    ) {}

    ngOnInit() {}

    ngOnChanges(changes: {rsvp: SimpleChange}) {
        const change: SimpleChange = changes.rsvp;
        if (null === change.currentValue) {
            return;
        }

        const rsvp: Rsvp = change.currentValue;

        this.rsvpForm.patchValue({
            identifier: rsvp.group.identifier
        });

        const guestArray = new FormArray([]);
        for (const guest of rsvp.group.guests) {
            this.guests.push(guest.name);
            guestArray.push(new FormControl(null === rsvp.rsvp));
        }
        this.rsvpForm.setControl('guests', guestArray);

        if (null === rsvp.rsvp) {
            return;
        }

        for (const guest of rsvp.rsvp.comingGuests) {
            guestArray.setControl(
                this.guests.indexOf(guest.name),
                new FormControl(true)
            );
        }

        this.decline = (0 === rsvp.rsvp.comingGuests.length);

        this.rsvpForm.patchValue({
            guests: guestArray.getRawValue(),
            needBabysitter: rsvp.rsvp.needBabysitter,
            needDriver: rsvp.rsvp.needDriver,
            hasAllergy: rsvp.rsvp.hasAllergy,
            favorite60sTube: rsvp.rsvp.favorite60sTube,
            favorite70sTube: rsvp.rsvp.favorite70sTube,
            favorite80sTube: rsvp.rsvp.favorite80sTube,
            favoriteContemporaryTube: rsvp.rsvp.favoriteContemporaryTube,
        });
    }

    toggleDecline(state) {
        this.decline = state;
    }

    saveRsvp() {

        const rsvp = this.rsvpForm.getRawValue();
              rsvp.comingGuests = [];

        if (!this.decline) {
            for (let i = 0; i < this.guests.length; i++) {
                if (!rsvp.guests[i]) {
                    continue;
                }

                rsvp.comingGuests.push(this.guests[i]);
            }
        }

        delete rsvp.guests;

        this.rsvpService.postRsvp(rsvp as Confirmation).subscribe(next => {
            this.submitted = true;

        }, error => {
            alert(
                'Désolé, un problème est survenu. \n' +
                'Merci d\'essayer plus tard et/ou de nous prévenir à l\'adresse mariage@beatriceetbrice.com.'
            );
        });
    }
}
