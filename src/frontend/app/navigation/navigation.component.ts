import {Component, OnInit} from '@angular/core';
import {SECTIONS} from './menu';

@Component({
    selector: 'app-navigation',
    templateUrl: './navigation.component.html',
    styleUrls: ['./navigation.component.css']
})

export class NavigationComponent implements OnInit {

    sections = SECTIONS;
    isMenuOpen = false;

    toggleMenu() {
        this.isMenuOpen = !this.isMenuOpen;
    }

    constructor() {}
    ngOnInit() {}
}
