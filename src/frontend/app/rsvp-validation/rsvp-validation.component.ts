import { AfterViewInit, Component, ElementRef, OnInit, ViewChild, Input } from '@angular/core';

@Component({
    selector: 'app-rsvp-validation',
    templateUrl: './rsvp-validation.component.html',
    styleUrls: ['./rsvp-validation.component.css']
})
export class RsvpValidationComponent implements OnInit, AfterViewInit {

    @Input() decline: boolean;

    @ViewChild('validationVideo') video: ElementRef;

    constructor() {}

    ngOnInit() {}

    ngAfterViewInit() {
        this.video.nativeElement.addEventListener('loadedmetadata', event => {
            this.video.nativeElement.muted = true;
        });
        this.video.nativeElement.addEventListener('canplaythrough', event => {
            this.video.nativeElement.muted = true;
        });

        this.video.nativeElement.addEventListener('canplay', event => {
            this.video.nativeElement.play();
        });
    }
}
