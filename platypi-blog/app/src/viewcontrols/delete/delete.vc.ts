import {register} from 'platypus';
import BaseViewControl from '../base/base.vc';
import PostsRepository from '../../repositories/posts/posts.repo';
import PostsService from '../../services/posts/posts.svc';

export default class DeleteViewControl extends BaseViewControl {
    templateString: string = require('./delete.vc.html');
    
    postId: number = 0;

    context: any = {};
    
    constructor(private postsRepository: PostsRepository, private postsService: PostsService) {
        super();
    }
    
    navigatedTo(params: { id: number; }): void {
        this.postId = Number(params.id);
    }
    
    loaded(): void {
        document.getElementById('deletePostButton').addEventListener('click', (event) => {
            this.deletePost();
        });
    }
    
    deletePost(): void {
        this.postsRepository.getPosts().then((posts) => {
            var index = this.postsRepository.find(this.postId, true);
            
            if(index) {
                this.postsRepository.posts.splice(index, 1);
                
                Array.prototype.forEach.call(this.postsRepository.posts, (post: any) => {
                    if(post.id > this.postId) {
                        post.id = (post.id - 1);
                    }
                });
                
                var data = JSON.stringify(this.postsRepository.posts);
                
                this.postsService.update(data).then((success) => {
                    console.log('Success!');
                });
            }
        });
    }
}

register.viewControl('delete-vc', DeleteViewControl, [PostsRepository, PostsService]);
