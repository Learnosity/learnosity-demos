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

    append(data) {
        if( !this.app || !data) {
            return
        }
        const wrapper = document.querySelector(`.${GCA_QUESTiON_WRAPPER}`);
        const div = document.createElement('DIV');

        div.className = `${GCA_RESPONSE_CONTAINER} question-${data.response_id}`;
        wrapper.appendChild(div);


        // #TODO: Fix the structure of this config to json
        const toAppend = {
               questions: [
                   data
               ],
               responses: {
                   [data.response_id]: {
                       value: ""
                   }
               }
            }

        this.app.append(toAppend);
    }
}
