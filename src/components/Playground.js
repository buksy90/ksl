import React from 'react';
import providers from '../dataProvider';

const playgrounds = providers.getPlaygroundsList();
const playgroundListItem = playgrounds.map( (playground,i) =>

    <li className="list-group-item list-group-item-action list-group-item-light" key={playground.id}>
    <a href='' > {playground.name} </a>
    <span className="float-right"> {playground.district} </span>
    </li>

);

export default playgroundListItem;

