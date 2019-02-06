import {async, register} from 'platypus';
import BaseService from '../base/base.svc';
import APIService from '../api/api.svc';

export default class PostsService extends BaseService {
    posts: Array<models.IPost> = [];
    
    constructor(private apiService: APIService) {
        super();
    }
    
    getPosts(): async.IThenable<Array<models.IPost>> {             
        return this.http.json({
           method: 'GET',
           url: this.apiService.postsURL()
        }).then(
            (success) => {
                return success.response;
            },
            
            (error) => {
                throw error.response.message;
            }
        );
    }
    
    update(post_data: any): async.IThenable<Array<models.IPost>> {        
        return this.http.json({
            method: 'PUT',
            url: this.apiService.postsURL(),
            data: post_data
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

register.injectable('posts-svc', PostsService, [APIService]);
