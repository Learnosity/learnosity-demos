import { waitElementToExist, delay } from '../utils';
import _ from 'lodash';
import {GCA_QUESTiON_WRAPPER, GCA_RESPONSE_CONTAINER} from "../contants";

export default class QuestionApiService {
    app = null;
    initializing = false;

    init(initOptions) {
        if (this.app) {
            this.app.reset();
        }

        if (!this.initializing) {
            this.initializing = true;

            return new Promise((resolve, reject) => {
                this.app = window.LearnosityApp.init(_.cloneDeep(initOptions), {
                    readyListener: () => {
                        this.initializing = false;
                        resolve(this.app);
                    },

                    errorListener: (error) => {
                        this.initializing = false;
                        this.app = null;

                        reject(error);
                    }
                });
            });
        }

        return Promise.reject();
    }

    async append( { question, state } ) {
        if(!(this.app && this.app.append)) {
            return Promise.reject();
        }

        const tempData = { ...question, state };
        const wrapper = document.querySelector(`.${GCA_QUESTiON_WRAPPER}`);
        if (wrapper.firstChild) {
            wrapper.removeChild(wrapper.firstChild);
        }
        const div = document.createElement('DIV');
        const randomizedString = Math.random().toString(36).substr(2, 6);
        tempData.response_id = `${tempData.type}-${randomizedString}`;

        div.className = `${GCA_RESPONSE_CONTAINER} question-${tempData.response_id}`;

        wrapper.appendChild(div);

        const toAppend = {
               questions: [
                   tempData
               ],
               responses: {
                   [tempData.response_id]: {
                       value: ""
                   }
               }
            };

        this.app.append(toAppend);

        await waitElementToExist(`#${tempData.response_id}`, wrapper);
        await delay(500);

        return Promise.resolve();
    }
}
