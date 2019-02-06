declare module models {
    interface IPost {
        id: number,
        userid: number,
        username?: string,
        title: string,
        body: string
    }
    
    interface IResponse {
        status: string;
        message?: string;
        data?: any;
        errors?: Array<Error>;
    }
    
    interface IUser {
        username: string;
        password: string;
        id: number;
    }
}
