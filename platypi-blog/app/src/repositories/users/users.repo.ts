import {async, register} from 'platypus';
import BaseRepository from '../base/base.repo';
import UsersService from '../../services/users/users.svc';

export default class UsersRepository extends BaseRepository {
    hasLoaded: boolean = false;
    
    constructor(private usersService: UsersService, public users: Array<models.IUser> = []) {
        super();
    }
    
    getUsers(): async.IThenable<Array<models.IUser>> {        
        if(this.hasLoaded === false) {
            return this.usersService.getUsers().then((users) => {
                this.utils.forEach((value, index) => {
                    this.users.push(value);
                }, users);
                
                this.hasLoaded = true;
                
                return this.users;
            });
        } else {
            return new async.Promise((users) => {
                return this.users;
            });
        }
    }
    
    find(id: number): any {
        this.utils.forEach((value, index) => {
            if(value.id === id) {
                return value;
            }
        }, this.users);
        
        return false;
    }
}

register.injectable('users-repo', UsersRepository, [UsersService]);
