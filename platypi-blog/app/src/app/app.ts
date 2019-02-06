import {App, events, register, routing} from 'platypus';
import HomeViewControl from '../viewcontrols/home/home.vc';
import ReadViewControl from '../viewcontrols/read/read.vc';
import CreateViewControl from '../viewcontrols/create/create.vc';
import DeleteViewControl from '../viewcontrols/delete/delete.vc';

export default class MyApp extends App {
    constructor(router: routing.Router) {
        super();

        router.configure([
            { pattern: '', view: HomeViewControl },
            { pattern: 'read/:id', view: ReadViewControl },
            { pattern: 'create', view: CreateViewControl },
            { pattern: 'delete/:id', view: DeleteViewControl }
        ]);
    }

    error(ev: events.ErrorEvent<Error>): void {
        console.log(ev.error);
    }
}

register.app('app', MyApp, [
    routing.Router
]);
