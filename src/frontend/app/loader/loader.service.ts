import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

import { LoaderState } from './loader';

@Injectable({
    providedIn: 'root'
})
export class LoaderService {

    private subject = new Subject<LoaderState>();

    state = this.subject.asObservable();

    constructor() {}

    start() {
        this.subject.next({ loading: true } as LoaderState);
    }

    stop() {
        this.subject.next({ loading: false } as LoaderState);
    }
}
