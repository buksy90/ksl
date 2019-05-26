import React, { PureComponent } from 'react';


export default class UpcomingMatches extends PureComponent {
    render() {
            return <div className="bg-light">
                     <div className="container p-3">
                        <div className="text-secondary border-bottom">
                            <h2 className="font-weight-normal">Najbližšie zápasy</h2>
                        </div>
                        <div className="text-white h5 bg-warning p-3 mt-3">
                             Žiadne ďalšie zápasy nie sú naplánované
                        </div>
                    </div>
                </div>;
    }
}