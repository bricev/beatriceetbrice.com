import { Component, OnInit } from '@angular/core';
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

export class HoneymoonComponent implements OnInit {

    constructor(
        private checkout: CheckoutService
    ) {}

    amount: string;
    pay() {
        this.checkout.pay(this.amount);
    }

    ngOnInit() {}
}
