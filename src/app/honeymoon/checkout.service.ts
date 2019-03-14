import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable()
export class CheckoutService {
    constructor(
        private http: HttpClient
    ) {}

    pay(amount): void {
        this.getSession(amount)
            .subscribe(
                session => this.redirect(session.session)
            );
    }

    private getSession(amount): Observable<any> {
        return this.http.get(environment.apiEndpoint + '/api/stripe/' + amount);
    }

    private redirect(session): void {
        Stripe(environment.stripeKey, {
            betas: [ 'checkout_beta_4' ]
        }).redirectToCheckout({
            sessionId: session,
        }).then(result => console.log('stripe error', result));
    }
}
