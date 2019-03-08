import { Section } from './section';

export const SECTIONS: Section[] = [
    { title: 'Accueil',      css: 'fas fa-home',           route: '/' },
    { title: 'Lieux',        css: 'fas fa-map-marker-alt', route: '/location' },
    { title: 'Hébergements', css: 'fas fa-concierge-bell', route: '/housing' },
    { title: 'Programme',    css: 'fas fa-calendar-check', route: '/planning' },
    { title: 'RSVP',         css: 'fas fa-envelope-open',  route: '/rsvp' },
    { title: 'Lune de Miel', css: 'fas fa-moon',           route: '/honeymoon' }
];
