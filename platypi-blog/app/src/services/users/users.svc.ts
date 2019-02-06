import {async, register} from 'platypus';
import BaseService from '../base/base.svc';
import APIService from '../api/api.svc';

export default class UsersService extends BaseService {
    constructor(private apiService: APIService) {
        super();
    }
    
    update(id: number, username: string, password: string): async.IThenable<boolean> {
        var user_data = {
            id: id,
            username: username,
            password: password
        };
        
        return this.http.json({
            method: 'PUT',
            url: this.apiService.usersURL(),
            data: user_data
        }).then(
            (success) => {
                return true;
            },
            
            (error) => {
                throw error.response.message;
            }
        );
    }
    
    getUsers(): async.IThenable<Array<models.IUser>> {        
        return this.http.json({
           method: 'GET',
           url: this.apiService.usersURL()
        }).then(
            (success) => {
                return success.response;
            },
            
            (error) => {
                throw error.response.message;
            }
        );
    }
}

register.injectable('users-svc', UsersService, [APIService]);
