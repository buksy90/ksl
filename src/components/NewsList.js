import React, { PureComponent } from 'react';
import providers from '../dataProvider';

export default class NewsList extends PureComponent {
    constructor(props){
        super(props);
        
        this.state = { list: [] };

        providers.getNewsList().then(data => {
          this.setState({ list: data.news });
        });
    }

    render() {
        return <div className="container">
                    <div className="border-bottom mt-2">
                        <h1 className="font-weight-light">Novinky</h1>
                    </div> 
                <ul className="list-group list-group-flush">
                  { this.state.list.map( (news,row) => {
                        return( <td key={row}>{news.id} {news.id} {news.title} {news.id} {news.date} </td>)
                    })
                  }
                </ul>
                </div>;
    }
}