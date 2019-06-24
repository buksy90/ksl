import React, { PureComponent } from 'react';
import TeamDetail from '../components/TeamDetail';

export default class NewsList extends PureComponent {
    render() {
        return <div className="container">
                    <div className="border-bottom mt-2">
                        <h1 className="font-weight-light">Novinky</h1>
                    </div> 
                    <TeamDetail />
                </div>;
    }
}