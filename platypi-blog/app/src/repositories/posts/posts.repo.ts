import {async, register} from 'platypus';
import BaseRepository from '../base/base.repo';
import PostsService from '../../services/posts/posts.svc'
import APIService from '../../services/api/api.svc';

export default class PostsRepository extends BaseRepository {
    hasLoaded: boolean = false;
    
    constructor(private postsService: PostsService, private apiService: APIService, public posts: Array<models.IPost> = []) {
        super();
    }
    
    getPosts(): async.IThenable<Array<models.IPost>> {        
        if(this.hasLoaded === false) {
            return this.postsService.getPosts().then((posts) => {
                this.utils.forEach((value, index) => {
                    this.posts.push(value);
                }, posts);
                
                this.hasLoaded = true;
                
                return this.posts;
            });
        } else {
            return new async.Promise((posts) => {
                return this.posts;
            })
        }
    }
    
    find(id: number, return_index: boolean = false): any {
        var post: any = {};
        
        this.utils.forEach((value, index) => {            
            if(value.id === id) {                
                if(return_index) {
                    post = index;
                } else {
                    post = value;
                }
            }
        }, this.posts);
        
        return post;
    }
    
    update(body: any, id: number): async.IThenable<Array<models.IPost>> {
        var post = this.find(id);
        
        if(post) {
            for(var i in this.posts) {
                if(JSON.stringify(post) === JSON.stringify(this.posts[i])) {
                    var post_data:any = {};
                    
                    post_data[i] = body;
                }
            }
        }
        
        return this.postsService.update(post_data).then((success) => {            
            return success;
        });

    }
}

register.injectable('posts-repo', PostsRepository, [PostsService, APIService]);
