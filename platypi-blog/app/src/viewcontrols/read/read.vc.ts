import {async, register, ui, web} from 'platypus';
import BaseViewControl from '../base/base.vc';
import PostsService from '../../services/posts/posts.svc';
import PostsRepository from '../../repositories/posts/posts.repo';
import UsersRepository from '../../repositories/users/users.repo';

export default class ReadViewControl extends BaseViewControl {
    templateString: string = require('./read.vc.html');

    post: models.IPost;
    id: number = 0;
    
    context: any = {
        post: <models.IPost> {
            id: 0,
            userid: 0,
            username: 'Anonymous',
            title: 'Post not found',
            body: 'The specified ID could not be found'
        }
    };
    
    constructor(private postsRepository: PostsRepository, private usersRepository: UsersRepository,
        private postsService: PostsService) {
        super();
    }
    
    showIcon(): void {                
        this.applyToIcons((node: Element) => {
            node.classList.remove('hidden');
        });
    }
    
    hideIcon(): void {                
        this.applyToIcons((node: Element) => {
            node.classList.add('hidden');
        });
    }
    
    disableIcon(): void {        
        this.applyToIcons((node: Element) => {
            node.setAttribute('disabled', 'true');
        });
    }
    
    enableIcon(): void {        
        this.applyToIcons((node: Element) => {
            node.removeAttribute('disabled');
        });
    }
    
    applyToIcons(callback: any): void {
        var nodes = document.getElementsByClassName('editIcon');
        
        Array.prototype.forEach.call(nodes, (node: Element) => {
            callback(node);
        });
    }
    
    commitChanges(): void {
        var post_data: models.IPost = {
            id: this.context.post.id,
            title: document.getElementById('title').innerText,
            userid: this.context.post.userid,
            username: this.context.post.username,
            body: document.getElementById('post-body').innerText
        };
        
        var index = this.postsRepository.find(this.context.post.id, true);
        
        this.postsRepository.posts.splice(index, 1);
        
        this.postsRepository.posts.push(post_data);
        
        var data = JSON.stringify(this.postsRepository.posts);
        
        this.disableIcon();
        
        this.postsService.update(data).then((success) => {            
            this.enableIcon();
            this.hideIcon();
        });
    }
    
    cancelChanges(): void {
        document.getElementById('title').innerText     = this.context.post.title;
        document.getElementById('post-body').innerText = this.context.post.body;
        
        this.hideIcon();
    }
    
    navigatedTo(params: { id: string; }, query: any) {        
        this.id = Number(params.id);
    }
    
    initialize(): void {
        this.postsRepository.getPosts().then((posts) => {
            this.getContext(this.id);
        });
    }
    
    getContext(id: number) {
        var post = this.postsRepository.find(id);
        
        if(post) {            
            this.post = post;
            
            this.usersRepository.getUsers().then((users) => {    
                var user = this.usersRepository.find(post.userid);
                
                if(user) {
                    post['userid']   = user.userid;
                    post['username'] = user.username;
                }
            });
            
            this.context.post = post;
        }         
    }
}

register.viewControl('read-vc', ReadViewControl, [PostsRepository, UsersRepository, PostsService]);
