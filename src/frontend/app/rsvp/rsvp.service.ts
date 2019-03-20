import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../../config/frontend/environment';
import { Confirmation } from './rsvp';

@Injectable()
export class RsvpService {
    constructor(
        private http: HttpClient
    ) {}

    getRsvp(code: string): Observable<any> {
        return this.http.get(environment.apiEndpoint + '/api/rsvp/' + code);
    }

    postRsvp(rsvp: Confirmation): Observable<any> {
        return this.http.post(environment.apiEndpoint + '/api/rsvp', rsvp);
    }
}
