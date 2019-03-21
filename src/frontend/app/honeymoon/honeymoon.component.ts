import { Component, OnInit, AfterViewInit, ViewChild, ElementRef } from '@angular/core';
import { CheckoutService } from './checkout.service';

@Component({
    selector: 'app-honeymoon',
    templateUrl: './honeymoon.component.html',
    providers: [ CheckoutService ],
    styleUrls: [
        '../../form.css',
        './honeymoon.component.css'
    ]
})
export class HoneymoonComponent implements OnInit, AfterViewInit {

    @ViewChild('honeymoonVideo') video: ElementRef;

    constructor(
        private checkout: CheckoutService
    ) {}

    amount: string;
    pay() {
        this.checkout.pay(this.amount);
    }

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
