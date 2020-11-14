import React, { PureComponent } from 'react';
import { View, Text, StyleSheet, AsyncStorage, TouchableOpacity, Image } from 'react-native';
import { Header } from 'react-native-elements';
import { Left, Right} from 'native-base';
import { ActivityIndicator, FlatList} from 'react-native';
import {Modal, TouchableHighlight, CheckBox, TextInput, Button, ScrollView, Dimensions } from 'react-native';
import Icon from 'react-native-vector-icons/FontAwesome';
//import Pagination from 'react-native-pagination';
import {List, ListItem, SearchBar} from "react-native-elements";
//import { DataTable, DataTableCell, DataTableRow, DataTablePagination } from 'material-bread';
import { DataTable } from 'react-native-paper';
//import SelectMultiple from 'react-native-select-multiple';
import { data } from './define';
//import { SelectMultipleGroupButton } from "../../index.js";
//import { SelectMultipleButton } from '../../libraries/SelectMultipleButton';
//import SimpleButton from "../../sample/SimpleButton";


import _ from "lodash";
//import { SelectMultipleButton } from "../../index.js";
import SelectMultipleButton from '../../libraries/SelectMultipleButton';

const multipleData = ["running ", "riding", "reading", "coding", "Niuer"];

const SCREEN_WIDTH = Dimensions.get("window").width;
const ios_blue = "#007AFF";
const themeColor = "#0D1014";
const server = data[0];

export default class TabOrderAll extends PureComponent {
      static navigationOptions = {
           title: '주문관리',
           headerStyle: {
             color: '#DB4437'
           },
           headerTintColor: '#DB4437',
           headerTitleStyle: {
              fontWeight: 'bold',
           },
      };

    constructor(props) {
         super(props);
         let date = new Date().getDate(); //To get the Current Date
         let month = new Date().getMonth() + 1; //To get the Current Month
         let year = new Date().getFullYear(); //To get the Current Year
         month = month >= 10 ? month: '0' + month;
         let searchOrder = [];

         // search order
         if (this.props.searchTextOrder) {
             searchOrder= {
                  "text_ten_phone_mave" : this.props.searchTextOrder,
                  "thoigian" : "0_2019-08-13_2020-08-13",
                  "checked_kenh" : "all",
                  "check_ncc" : 'all'
            };
          }
         this.state = {
           loading: false,
           contentWarning: '',
           statusNext: 0,
           page: 1,
           perPage: 50,
           totalRow: 0,
           dataApi: [],
           statusDetail: [],
           channelAPI: [],
           nccAPI: [],
           isLoading: true,
           username: "",
           date:  new Date().getSeconds(),
           isSelected: false,
           refreshing: false,
           datasearch: searchOrder,
           searchtext: this.props.searchTextOrder ? this.props.searchTextOrder : '',
           searchAll: '필터',
           toDay: year + '-' + month + '-' + date,
           fromDay: year + '-' + month + '-' + date,
           days: ["jan","feb","Mar"],
           modalVisible: false,
           modalVisibleUse: false,
           detaiModalVisible: false,
           usageScrollView: null,
           multipleSelectedData: [],
           multipleSelectedDataLimited: [],
           multipleSelectedDataDetail: [],
           multipleSelectedDataDetailLimited: [],
           multipleSelectedDataNCC: [],
           multipleSelectedDataNCCLimited: [],
           delElementDetail: '',
           delElementNCC: '',
           selectedAllCheckbox: [],
           searchTicket: [],
           statusUse: 0,
           statusRestore: 0,
           searchTextNCC: 'all',
           searchTextChannel: 'all',
           searchtextDetail: '0_2019-08-13_2020-08-13'
         };

         this.loadPagination = this.loadPagination.bind();
         this.loadMoreOrderAPI = this.loadMoreOrderAPI.bind();
         this.loadChannelAPI = this.loadChannelAPI.bind();
         this.loadChannelAPI1 = this.loadChannelAPI1.bind();
         this.submitSetting = this.submitSetting.bind();
         this.toggleCheckbox = this.toggleCheckbox.bind();
         this.updateSatusTreatment = this.updateSatusTreatment.bind();
         this.updateSatusRestore  = this.updateSatusRestore.bind();
    }


    componentDidMount() { //auto run function
           //console.log('method: ', this.props.method); // Get method api

           // get session
           AsyncStorage.getItem('accountshopping', (err, result) => {

                       //console.log('user', result);
                      //console.log('searchOrder hi ', this.state.datasearch);
                       //this.setState({loading: true});
                       fetch(server+'orderApi.html', {
                               method: 'POST',
                               headers: {
                                 Accept: 'application/json',
                                 'Content-Type': 'application/json',
                               },
                               body: JSON.stringify({
                                  account_idx: JSON.parse(result).account_idx,
                                  account_ID: JSON.parse(result).account_ID,
                                  account_role: JSON.parse(result).account_role,
                                  method: this.props.method ? this.props.method : '',
                                  page : this.state.page,
                                  datasearch : this.state.datasearch
                               }),
                             })
                        .then((response) => response.json())
                        .then((responseJson) => {
                            //console.log(this.state.datasearch);
                            //console.log('zo zo ', responseJson);
                            if (responseJson.result) {
                                // console.log('page mount', this.state.page);
                                //console.log('ticket number', responseJson.list_order.data[0].ticketNumber);
                                this.setState({ dataApi: responseJson.list_order.data ,
                                                totalRow: responseJson.list_order.count,
                                                loading: false,
                                                refreshing: false });
                                 //this.setState({dataApi: this.state.page === 1 ? responseJson.list_order.data : [...this.state.dataApi, ...responseJson.list_order.data], totalRow: responseJson.list_order.count, loading: false,  refreshing: false });
                            }
                        })
                        .catch((error) => this.setState({loading: false}))
                        .finally(() => {
                             this.setState({ isLoading: false });
                        });

           });
     }

     submitSearch(event) {
        //console.log('searchtext', this.state.searchtext);

       let search= {
            "text_ten_phone_mave" : this.state.searchtext,
            "thoigian" : this.state.searchtextDetail,
            "checked_kenh" : this.state.searchTextChannel,
            "check_ncc" : this.state.searchTextNCC
            };
        this.setState({datasearch: search});

        this.setState(
             {
                 datasearch: search,
                 date: new Date().getSeconds()
             },
             () => {
                 //console.log('search find ', this.state.datasearch);
                 this.setState({isLoading: true});
                 this.componentDidMount();
             }
         );
     }

    submitModalSearch(event) {
        let searchAll = '';
        let daySearch = '0_2019-08-13_2020-08-13';
        if (this.state.multipleSelectedDataDetailLimited.length > 0) {

              // detail

            switch (this.state.multipleSelectedDataDetailLimited[0]) {
             case '전체':
                   daySearch = '0_2019-08-13_2020-08-13';
                   searchAll = '전체';
                   break;
              case '어제':
                   daySearch = '1_2019-08-13_2020-08-13';
                   searchAll = '어제';
                   break;
              case '오늘':
                    daySearch = '2_2019-08-13_2020-08-13';
                    searchAll = '오늘';
                    break;
              case '최근7일':
                    daySearch = '3_2019-08-13_2020-08-13';
                    searchAll = '최근7일';
                    break;
              case '최근1개월':
                    daySearch = '4_2019-08-13_2020-08-13';
                    searchAll = '최근1개월';
                    break;
              case '최근3개월':
                    daySearch = '5_2019-08-13_2020-08-13';
                    searchAll = '최근3개월';
                    break;
              case '최근6개월':
                    daySearch = '6_2019-08-13_2020-08-13';
                    searchAll = '최근6개월';
                    break;
              case '직접입력':
                   daySearch = '7_' + this.state.toDay + '_' + this.state.fromDay;
                   searchAll = '직접입력';
                   break;
              default :
                    return null;

            }
        }

        searchAll = '#' + searchAll;
        this.setState({searchtextDetail : daySearch});
        //console.log('detail ', daySearch);
        // channel
        let channelModalSerach = 'all';
        if (this.state.multipleSelectedDataLimited.length > 0 && this.state.multipleSelectedDataLimited[0] !== '전체' && this.state.multipleSelectedDataLimited[this.state.multipleSelectedDataLimited.length -1] !== '전체') {
            channelModalSerach = '';
            for (let i =0 ; i < this.state.multipleSelectedDataLimited.length; i += 1) {
                channelModalSerach += this.state.multipleSelectedDataLimited[i] + '_';
            }
        }

        this.setState({searchTextChannel : channelModalSerach});
        searchAll += '#' + channelModalSerach;

        //console.log('chan ', channelModalSerach);

        // NCC

        let nccModalSerach = 'all';

        if (this.state.multipleSelectedDataNCCLimited.length > 0 && this.state.multipleSelectedDataNCCLimited[0] !== 'all') {
              nccModalSerach = this.state.multipleSelectedDataNCCLimited[0];
        }

        if (nccModalSerach !== 'all') {
            let nccData = this.state.nccAPI.find((item) => item.idx == nccModalSerach);
            if (nccData) nccModalSerach = nccData.company;
        }

        this.setState({searchTextNCC : nccModalSerach});
        searchAll += '#' + nccModalSerach;
        this.setState({searchAll: searchAll});
        //console.log('ncc ', nccModalSerach);
        this.setState({ modalVisible: false });

        let search= {
            "text_ten_phone_mave" : this.state.searchtext,
            "thoigian" : daySearch,
            "checked_kenh" : channelModalSerach,
            "check_ncc" : nccModalSerach
            };
        this.setState({datasearch: search});
        this.setState(
             {
                 datasearch: search,
                 date: new Date().getSeconds()
             },
             () => {
                 //console.log('search find ', this.state.datasearch);
                 this.setState({isLoading : true});
                 this.componentDidMount();
             }
         );
    }

    loadMoreOrderAPI = (page) => {

             this.setState(
                 {
                     page: page
                 },
                 () => {
                     this.setState({isLoading : true});
                     this.componentDidMount();
                 }
             );

     };



     loadPagination = () => {
        let totalPage = Math.ceil(this.state.totalRow / this.state.perPage);
        let dataPagination = [];
        let dataPaginationPre = [];
        let dataPaginationNext = [];
        // getPrePage
        if (this.state.page != 1) {
            dataPaginationPre.push(this.state.page -1);
        }

        // getNextPage
        if (this.state.page < totalPage) {
            dataPaginationNext.push(this.state.page + 1);
        }

        // get pagination
        // for (let i = (this.state.page - 4) > 0 ? (this.state.page - 4) : 1; i <= ((this.state.page + 4) > totalPage ? totalPage : (this.state.page + 4)); i += 1) {
        for (let i = this.state.page; i <= ((this.state.page + 4) > totalPage ? totalPage : (this.state.page + 4)); i += 1) {
            dataPagination.push(i);
        }

        return (
           <View style={{flex: 1, flexDirection: 'row'}}>
            {

                dataPaginationPre.map((item, index) => <View key={index} style={this.state.page == item ? styles.buttonPaginationActive : styles.buttonPagination} >
                                                <TouchableOpacity activeOpacity={0.95} onPress={() => this.loadMoreOrderAPI(item)} >
                                                    <Text > {"<"} </Text>
                                                </TouchableOpacity>
                                             </View>
                                     )
            }

            {

              dataPagination.map((item, index) => <View key={index} style={this.state.page == item ? styles.buttonPaginationActive : styles.buttonPagination} >
                                            <TouchableOpacity activeOpacity={0.95} onPress={() => this.loadMoreOrderAPI(item)} >
                                                <Text >{item}</Text>
                                            </TouchableOpacity>
                                         </View>
                                 )
            }

            {

                dataPaginationNext.map((item, index) => <View key={index} style={this.state.page == item ? styles.buttonPaginationActive : styles.buttonPagination} >
                                                <TouchableOpacity activeOpacity={0.95} onPress={() => this.loadMoreOrderAPI(item)} >
                                                    <Text > {">"} </Text>
                                                </TouchableOpacity>
                                             </View>
                                     )
            }
            </View>
        )
   };

    loadChannelAPI = () => {
        AsyncStorage.getItem('accountshopping', (err, result) => {
                   //console.log('user', result);
                   fetch(server+'channelApi.html', {
                           method: 'POST',
                           headers: {
                             Accept: 'application/json',
                             'Content-Type': 'application/json',
                           },
                           body: JSON.stringify({
                              account_idx: JSON.parse(result).account_idx,
                              account_ID: JSON.parse(result).account_ID,
                              account_role: JSON.parse(result).account_role
                           }),
                         })
                    .then((response) => response.json())
                    .then((responseJson) => {
                        console.log('channel: ', responseJson);
                        if (responseJson.result) {
                            let dataChannel = responseJson.channelApi;
                            dataChannel.unshift('전체');
                            //this.setState({ nccAPI: responseJson.nccApi});
                            //this.setState({ channelAPI: dataChannel, nccAPI: responseJson.nccApi});
                            for (let i = 0 ; i < dataChannel.length ; i ++) {
                                this.state.multipleSelectedDataLimited.push(dataChannel[i]);
                            }
                            this.setState({ channelAPI: dataChannel, nccAPI: responseJson.nccApi});

                        }
                    })
                    .catch((error) => console.log(error))
                    .finally(() => {
                         this.setState({ isLoading: false });
                    });
       });
    }


    toggleModal(visible) {
      let statusDetail  =  [
      '전체',
      '어제',
      '오늘',
      '최근7일',
      '최근1개월',
      '최근3개월',
      '최근6개월',
      '직접입력'
      ];

//      while(this.state.multipleSelectedDataDetailLimited.length > 0){
//          this.state.multipleSelectedDataDetailLimited.pop();
//      }
      this.state.multipleSelectedDataDetailLimited = [];

//      while(this.state.multipleSelectedDataLimited.length > 0){
//          this.state.multipleSelectedDataLimited.pop();
//      }
     this.state.multipleSelectedDataLimited = [];
//      while(this.state.multipleSelectedDataNCCLimited.length > 0){
//        this.state.multipleSelectedDataNCCLimited.pop();
//      }
      this.state.multipleSelectedDataNCCLimited = [];
      this.state.multipleSelectedDataDetailLimited.push('전체');
      //this.state.multipleSelectedDataLimited.push('전체');
      this.state.multipleSelectedDataNCCLimited.push('all');
      this.loadChannelAPI();
      //this.loadNCCAPI();
      //this.setState({statusDetail: statusDetail});
      this.setState({modalVisible: visible, statusDetail: statusDetail});
    }

    closeModal(visible) {
       this.setState({ modalVisible: visible });
    };

    closeModalUse(visible) {
       this.setState({ modalVisibleUse: visible });
    };

    submitSetting = () => {
//        while(this.state.multipleSelectedDataDetailLimited.length>0){
//            this.state.multipleSelectedDataDetailLimited.pop();
//        }
        this.state.multipleSelectedDataDetailLimited = [];
//         while(this.state.multipleSelectedDataLimited.length>0){
//            this.state.multipleSelectedDataLimited.pop();
//         }
        this.state.multipleSelectedDataLimited = [];

//         while(this.state.multipleSelectedDataNCCLimited.length>0){
//             this.state.multipleSelectedDataNCCLimited.pop();
//          }
            this.state.multipleSelectedDataNCCLimited = [];

        // this.setState({multipleSelectedDataNCCLimited: this.state.multipleSelectedDataNCCLimited});
        this.setState({date: new Date().getSeconds()});

    };
     // selected detail
     _singleTapMultipleSelectedButtonsDetail(interest) {

             if (this.state.multipleSelectedDataDetail.includes(interest)) {
               _.remove(this.state.multipleSelectedDataDetail, ele => {
                 return ele === interest;
               });
             } else {

               this.state.multipleSelectedDataDetail.push(interest);
             }

             this.setState({
               multipleSelectedDataDetail: this.state.multipleSelectedDataDetail
             });
         }

         _singleTapMultipleSelectedButtonsDetail_limited(interest) {

             if (this.state.multipleSelectedDataDetailLimited.includes(interest)) {
               _.remove(this.state.multipleSelectedDataDetailLimited, ele => {
                 return ele === interest;
               });
               //this.setState({detaiModalVisible: false});
               //console.log('select del detail ', this.state.multipleSelectedDataDetailLimited);
               this.setState({date: new Date().getSeconds()});
             } else {

                 // remove previous element

                 //if (this.state.multipleSelectedDataDetailLimited.length > 0) {
                      //console.log('xoa: ', this.state.multipleSelectedDataDetailLimited[0]);

                     _.remove(this.state.multipleSelectedDataDetailLimited, ele => {
                        this.setState({delElementDetail: this.state.multipleSelectedDataDetailLimited[0]});
                        return ele === this.state.multipleSelectedDataDetailLimited[0];
                     });
                // }

                 //console.log('sau khi xoa: ', this.state.multipleSelectedDataDetailLimited);
                 this.state.multipleSelectedDataDetailLimited.push(interest);
                 if ( this.state.multipleSelectedDataDetailLimited[0] === '직접입력') {
                    this.setState({detaiModalVisible: true});
                 }else {
                    this.setState({detaiModalVisible: false});
                 }
                 //console.log('select in detail ', this.state.multipleSelectedDataDetailLimited);
                 this.setState({date: new Date().getSeconds()});
             }

             this.setState({
               multipleSelectedDataDetailLimited: this.state.multipleSelectedDataDetailLimited
             });

         }

    // selected channel
    _singleTapMultipleSelectedButtons(interest) {

        if (this.state.multipleSelectedData.includes(interest)) {
          _.remove(this.state.multipleSelectedData, ele => {
          //console.log('zo  ', interest);
            return ele === interest;
          });
        } else {
            //console.log('zo he ', interest);
          this.state.multipleSelectedData.push(interest);
        }

        this.setState({
          multipleSelectedData: this.state.multipleSelectedData
        });
    }

    _singleTapMultipleSelectedButtons_limited(interest) {
        //console.log('interest  ',interest);
        console.log('multipleSelectedDataLimited hi', this.state.multipleSelectedDataLimited);
        if (this.state.multipleSelectedDataLimited.includes(interest)) {
            if (interest === '전체') {
//                while(this.state.multipleSelectedDataLimited.length>0){
//                    this.state.multipleSelectedDataLimited.pop();
//                }
            this.state.multipleSelectedDataLimited = [];
            }else{
                let index = this.state.multipleSelectedDataLimited.indexOf(interest);
                if (index > -1) {
                  this.state.multipleSelectedDataLimited.splice(index, 1);
                  let index1 = this.state.multipleSelectedDataLimited.indexOf('전체');
                  if (index1 > -1) {
                    this.state.multipleSelectedDataLimited.splice(index1, 1);
                  }
                }
            }

          this.setState({date: new Date().getSeconds()});

        } else {
          //if (this.state.multipleSelectedDataLimited.length < 3)
          if (interest === '전체') {
//                while(this.state.multipleSelectedDataLimited.length>0){
//                       this.state.multipleSelectedDataLimited.pop();
//                }
                this.state.multipleSelectedDataLimited = [];
                for (let i = 0 ; i < this.state.channelAPI.length ; i ++) {
                    this.state.multipleSelectedDataLimited.push(this.state.channelAPI[i]);
                }
                this.setState({date: new Date().getSeconds()});
                //
                let j = 0;
          }else {

                this.state.multipleSelectedDataLimited.push(interest);
                let j=0;
                for (let i = 0 ; i < this.state.channelAPI.length ; i ++) {
                    if (this.state.multipleSelectedDataLimited.includes(this.state.channelAPI[i]))
                        j++;
                }
                if(j==(this.state.channelAPI.length-1))
                    this.state.multipleSelectedDataLimited.push('전체');
                this.setState({date: new Date().getSeconds()});

          }

        }

        this.loadChannelAPI1.bind();

    }
    loadChannelAPI1 = () => {
           //console.log("loadChannelAPI 1 ",this.state.multipleSelectedDataLimited);
            return (
             <View style={{flexWrap: "wrap", flexDirection: 'row'}}>

                     {

                         this.state.channelAPI.map(interest => (
                            <SelectMultipleButton
                              key={interest}
                              buttonViewStyle={{

                                height: 46
                              }}
                              textStyle={{
                                fontSize: 12
                              }}

                              highLightStyle={{
                                borderColor: "gray",
                                backgroundColor: "transparent",
                                borderTintColor: 'gray',
                                backgroundTintColor: 'gray',
                                textColor: "gray",
                                textTintColor: 'gray'
                              }}

                              value={interest}
                              selected={this.state.multipleSelectedDataLimited.includes(
                                interest
                              )}
                              singleTap={valueTap =>
                                this._singleTapMultipleSelectedButtons_limited(interest)
                              }
                            />
                        ))
                    }
                    </View>

             )
    }
    // selected NCC
     _singleTapMultipleSelectedButtonsNCC(interest) {

             if (this.state.multipleSelectedDataNCC.includes(interest)) {
               _.remove(this.state.multipleSelectedDataNCC, ele => {
                 return ele === interest;
               });
             } else {

               this.state.multipleSelectedDataNCC.push(interest);
             }

             this.setState({
               multipleSelectedDataNCC: this.state.multipleSelectedDataNCC
             });
         }

         _singleTapMultipleSelectedButtonsNCC_limited(interest) {

             if (this.state.multipleSelectedDataNCCLimited.includes(interest)) {
               _.remove(this.state.multipleSelectedDataNCCLimited, ele => {
                 return ele === interest;
               });
               //console.log('select del NCC ', this.state.multipleSelectedDataNCCLimited);
               this.setState({date: new Date().getSeconds()});

             } else {
               //if (this.state.multipleSelectedDataNCCLimited.length < 1)
                 _.remove(this.state.multipleSelectedDataNCCLimited, ele => {
                     this.setState({delElementDetail: this.state.multipleSelectedDataNCCLimited[0]});
                     return ele === this.state.multipleSelectedDataNCCLimited[0];
                  });
                 this.state.multipleSelectedDataNCCLimited.push(interest);
                 console.log('select in NCC', this.state.multipleSelectedDataNCCLimited);
                 this.setState({date: new Date().getSeconds()});
             }

             this.setState({
               multipleSelectedDataNCCLimited: this.state.multipleSelectedDataNCCLimited
             });

         }

     submitSelectedAllCheckbox(event) {
        if (!this.state.isSelected) {
            this.setState({isSelected: !this.state.isSelected});
            this.state.selectedAllCheckbox = [];
            this.state.dataApi.map( item => {
                console.log('item: ', item);
                this.state.selectedAllCheckbox.push(item);
            });
        }else {
            this.setState({isSelected: !this.state.isSelected});
//            while (this.state.selectedAllCheckbox.length > 0) {
//                this.state.selectedAllCheckbox.pop();
//            }
            this.state.selectedAllCheckbox=[];
        }
        this.setState({date: new Date().getSeconds()});
     }

     updateSatusRestore  = () => {
        // this.setState({statusNext: 1});
         this.handleUseRestore(1);
     };
      updateSatusTreatment  = () => {
           //this.setState({statusNext: 2});
           this.handleUseRestore(2);
      };

      handUpdateUseRestore = () => {
           this.setState({modalVisibleUse: !this.state.modalVisibleUse});
           //console.log('selectedAllCheckbox ' + this.state.selectedAllCheckbox.length + ': ' , this.state.selectedAllCheckbox);
           //console.log('searchTicket ' + this.state.searchTicket.length + ': ' , this.state.searchTicket);
           if (this.state.searchTicket.length < 1)  return;
           this.setState({isLoading: true});
         // get session
          if (this.state.searchTicket.length > 0) {
               AsyncStorage.getItem('accountshopping', (err, result) => {
               this.setState({loading: true});
                   fetch(server+'changestatusApi.html', {
                           method: 'POST',
                           headers: {
                             Accept: 'application/json',
                             'Content-Type': 'application/json',
                           },
                           body: JSON.stringify({
                              account_idx: JSON.parse(result).account_idx,
                              account_ID: JSON.parse(result).account_ID,
                              account_role: JSON.parse(result).account_role,
                              array_ticket : this.state.searchTicket
                           }),
                         })
                    .then((response) => response.json())
                    .then((responseJson) => {
                        //console.log('zo zo: ', responseJson);
                        if (responseJson.result) {
//                            while (this.state.selectedAllCheckbox.length > 0) {
//                                  this.state.selectedAllCheckbox.pop();
//                            }
                        this.state.selectedAllCheckbox = [] ;
                            this.setState({isLoading: true});
                            this.componentDidMount();
                        }
                    })
                    .catch((error) => this.setState({loading: false}))
                    .finally(() => {
                         this.setState({ isLoading: false });
                    });

               });
            }
      }

      handleUseRestore(status){
      console.log('selectedAllCheckbox ', this.state.selectedAllCheckbox);
           this.setState({modalVisibleUse: !this.state.modalVisibleUse});
           this.setState({statusNext: 0});
           if (this.state.selectedAllCheckbox.length < 1) {
                //this.setState({modalVisibleUse: !this.state.modalVisibleUse});
                this.setState({contentWarning : '상품을 1개 이상 선택해주세요.'});
                return;
           }
//           while (this.state.searchTicket.length > 0) {
//                 this.state.searchTicket.pop();
//           }
            this.state.searchTicket = [];
           this.state.selectedAllCheckbox.map( item => {
               if (status == 2) {
                   if (item.statusTicket == 1) {
                        this.setState({contentWarning : '선택한 상품을 사용처리로 변경합니다. 계속하시겠습니까?'});
                        this.state.searchTicket.push({'id' : item.ticketNumber, 'status': status, 'restore' : item.restoreTicket });
                   } else {
                        this.setState({contentWarning : '구매완료 상품만 적용 가능합니다.'});
                   }

               } else {
                    if (item.statusTicket == 2 || item.statusTicket == 3) {
                        this.setState({contentWarning : '선택한 상품을 사용처리로 변경합니다. 계속하시겠습니까?'});
                        this.state.searchTicket.push({'id' : item.ticketNumber, 'status': status, 'restore' : item.restoreTicket });
                    } else {
                        this.setState({contentWarning : '사용완료 상품만 적용 가능합니다 - 환불요청중 티켓'});
                    }
               }

           });

           if ((this.state.selectedAllCheckbox.length >= this.state.searchTicket.length) && this.state.searchTicket.length > 0) {
                this.setState({statusNext: status});
                if (status == 2) {
                    this.setState({contentWarning : this.state.selectedAllCheckbox.length + ' 개의 티켓 중 구매완료 티켓 ' + this.state.searchTicket.length + '개를 사용처리하시겠습니까?'});
                }else{
                    this.setState({contentWarning : this.state.selectedAllCheckbox.length + ' 개의 티켓 중 사용완료 or 환불요청중 티켓 ' + this.state.searchTicket.length + '개를 복원처리하시겠습니까?'});
                }

           }else {
                if ((this.state.selectedAllCheckbox.length == this.state.searchTicket.length) && this.state.searchTicket.length > 1) {
                    this.setState({statusNext: status});
                    this.setState({contentWarning : '선택한 상품을 사용처리로 변경합니다. 계속하시겠습니까?'});
                }
           }
           this.setState({date: new Date().getSeconds()});
      };

      toggleCheckbox = (item) => {
         let index = this.state.selectedAllCheckbox.indexOf(item);
         //console.log('index:  ', index);
         if (index > -1) {
            this.state.selectedAllCheckbox.splice(index, 1);
         }else {
            this.state.selectedAllCheckbox.push(item);
            this.setState({selectedAllCheckbox: this.state.selectedAllCheckbox});
            //console.log('checkbox item: ', this.state.selectedAllCheckbox);
         }

        //console.log('checkbox item: ', this.state.selectedAllCheckbox);
         this.setState({date: new Date().getSeconds()});
      }

    render () {
        const { navigation } = this.props;

        return (

            <View style={styles.container}>
                <View style={{ borderColor: '#ccc', backgroundColor: '#f2f2f2', borderWidth: 1 }}>
                    <View style={{height: 40,  paddingTop: 7, left: 20}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '79%'}} >
                               <TouchableOpacity activeOpacity={0.95}>
                                  <TextInput style={{borderWidth: 0.5, borderColor: '#607D8B', backgroundColor: '#fff', paddingLeft: 2}} value={this.state.searchtext}
                                       onChangeText={searchtext =>
                                           this.setState({ searchtext })
                                       }
                                       ref={input => {
                                           this.textInput = input;
                                       }}  placeholder="홍길동 (name)"/>
                               </TouchableOpacity>
                           </View>
                       </View>
                    </View>
                    <View style={{height: 40,  paddingTop: 8, left: 20}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '79%', bottom: 5}} >
                               <TouchableOpacity activeOpacity={0.95} onPress = {() => {this.toggleModal(true)}}>
                                  <TextInput style={{borderWidth: 0.5, borderColor: '#607D8B', backgroundColor: '#f2f2f2', textAlign: 'center'}} value={this.state.searchAll}  editable={false} />
                               </TouchableOpacity>
                           </View>
                       </View>
                    </View>
                </View>
                <View style={{width: 45,  position: 'absolute', right: 65, top: 9}}>
                    <Icon.Button style={{ backgroundColor: '#DB4437', height: 28}}
                       name='search'
                        onPress={this.submitSearch.bind(this)}
                    >
                    </Icon.Button>
                </View>
                <View style={{  position: 'absolute', right: 73, top: 50}}>
                    <TouchableOpacity onPress = {() => {this.toggleModal(true)}}>
                        <Image source={require('../../assets/ic_boloc.png')} style={{ height: 20, width: 25 }} />
                    </TouchableOpacity>
                </View>

                <View style= {{ width: '100%', top: 5, height:10, flexDirection: "row" }}>

                    <View style={{width: 70, height: 30, margiRight: 10 , alignItems: 'center', justifyContent: 'center'}} >
                          <Text style={styles.contentStyle}>총 {this.state.totalRow}</Text>
                      </View>

                    <View style={{flex: 1, flexDirection: 'row-reverse'}}>
                          {(this.props.method === '' || this.props.method === 'use' || this.props.method === 'unuse') &&
                          <View style={{width: 70, height: 30, backgroundColor: '#DB4437', marginRight: 10, alignItems: 'center', justifyContent: 'center'}} >
                                <TouchableOpacity activeOpacity={0.95}  onPress={this.updateSatusRestore.bind(this)} >
                                    <Text style={styles.contentStyleColor}>복원처리</Text>
                               </TouchableOpacity>
                          </View>
                          }
                          {(this.props.method === '' || this.props.method === 'done') &&
                          <View style={{width: 70, height: 30, backgroundColor: '#DB4437', marginRight: 5, alignItems: 'center', justifyContent: 'center'}} >
                              <TouchableOpacity activeOpacity={0.95} onPress={this.updateSatusTreatment.bind(this)} >
                                  <Text style={styles.contentStyleColor}>사용처리</Text>
                             </TouchableOpacity>
                          </View>
                          }

                          <View style={{width: 70, height: 30, backgroundColor: '#f2f2f2', marginRight : 5, alignItems: 'center', justifyContent: 'center',}} >
                                <TouchableOpacity activeOpacity={0.95} onPress={this.submitSelectedAllCheckbox.bind(this)} >
                                    <Text style={styles.contentStyle}>모두 선택</Text>
                               </TouchableOpacity>
                          </View>

                    </View>
                </View>

               <View style= {{ alignItems: 'center', width: '100%', top: 20 }}>
                {this.state.isLoading ? <ActivityIndicator size = "large"/> : (

                     <FlatList
                          data={this.state.dataApi}
                          keyExtractor={({ id }, index) => id}
                          renderItem={({ item, index }) => (

                          <View style= {styles.contentOrder}>
                              <View style={{flex: 1, flexDirection: 'row'}}>
                                 <View style={styles.contentOrderLeft}>
                                    <View >
                                        <Text style={styles.textPurcharse}>
                                        {item.statusTicket == -1? '유효기간지남' : item.statusTicket == 1? '구매완료'
                                            : item.statusTicket == 2? '사용완료' : item.statusTicket == 3? '환불요청중'
                                            : item.statusTicket == 4? '환불완료' : '유효기간지남'}
                                        </Text>
                                    </View>
                                    <View style={{ padding: '15%'}}>
                                        <CheckBox
                                          value={this.state.selectedAllCheckbox.find((cb) => cb.ticketNumber == item.ticketNumber) ? true : false}
                                          onChange={() => this.toggleCheckbox(item)}
                                         />
                                    </View>
                                 </View>
                                 <View style={styles.contentOrderRight}>
                                    <Text style={styles.textbold}>T-Bridge: {item.ticketNumber}</Text>
                                    <Text style={styles.textbold}>채널사명: {item.channel_name}</Text>
                                    <View style={{marginTop: 10}}>
                                        <Text> {item.dealName}</Text>
                                        <Text> {item.optionName}</Text>
                                        <Text> {item.userName} [{item.phoneNumber}]</Text>
                                        <Text>[{item.purchaseDateTime}]</Text>
                                    </View>
                                 </View>
                              </View>
                        </View>
                    )}

                 />

             )}
                </View>
                {!this.state.isLoading && this.state.totalRow > this.state.perPage &&
                <View style={{ width: '100%', height: 35, alignItems: 'center', justifyContent: 'center', bottom: 0, position: 'absolute', backgroundColor: '#f2f2f2'}}>
                      {this.loadPagination()}
                </View>
                }
                <Modal animationType = {"slide"} transparent = {false}
                   visible = {this.state.modalVisible}
                   style={{width: '100%', backgroundColor: 'rgba(0,0,0,0.4)'}}
                   onRequestClose = {() => { console.log("Modal has been closed.") } }>
                   <ScrollView>
                   <View style={{height:60,  paddingTop:15, left: 20, bottom: 15}}>
                       <View style={{flex: 1, flexDirection: 'row', top: 10, left: 20, width: '100%'}}>
                           <View style={{alignItems: 'center', justifyContent: 'center', width: 50, height: 30, right: 10, backgroundColor: '#fdeada', borderColor: '#c00000', borderWidth: 1}}>
                               <TouchableHighlight onPress = {() => {
                                    this.submitSetting()}}>
                                    <Text style = {{alignItems: 'center', justifyContent: 'center', color: '#c00000'}}>Đặt lại </Text>
                               </TouchableHighlight>
                           </View>
                           <View style={{width: '70%', padding: 2}}><Text style={styles.textTitleModal}>tình trạng chi tiết</Text></View>
                           <View style={{alignItems: 'center', justifyContent: 'center', width: 50, height: 30, right: 20}}>
                              <TouchableHighlight onPress = {() => {
                                   this.closeModal(!this.state.modalVisible)}}>
                                   <Text style = {{alignItems: 'center', justifyContent: 'center', color: '#6d6767ad', fontSize: 22}}>X </Text>
                              </TouchableHighlight>
                           </View>
                       </View>
                   </View>
                   <View style={{ width: '100%', paddingTop: 10}}>
                        <Text style={styles.textTitleModal}>Điều tra kỳ</Text>
                   </View>
                   <View style={{ left: 2}}>
                        {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                        <View
                              style={{
                                flexWrap: "wrap",
                                flexDirection: "row",
                              }}
                         >
                            {this.state.statusDetail.map(interest => (
                                <SelectMultipleButton
                                  key={interest}
                                  buttonViewStyle={{
                                    height: 46,
                                  }}
                                  textStyle={{
                                    fontSize: 12
                                  }}
                                  highLightStyle={{
                                    borderColor: "gray",
                                    backgroundColor: "transparent",
                                    borderTintColor: 'gray',
                                    backgroundTintColor: 'gray',
                                    textColor: "gray",
                                    textTintColor: 'gray'
                                  }}

                                  value={interest}
                                  selected={this.state.multipleSelectedDataDetailLimited.includes(
                                    interest
                                  )}
                                  singleTap={valueTap =>
                                    this._singleTapMultipleSelectedButtonsDetail_limited(interest)
                                  }

                                />
                              ))}
                        </View>
                     )}
                       { this.state.detaiModalVisible &&
                        <View style={{flex: 1, flexDirection: 'row', width: '100%', top: 5, left: 2}}>
                            <View style={{ width: '45%'}}>
                               <Text style={{fontSize: 16}}>Đầu vào trực tiếp của kỳ</Text>
                            </View>
                            <View style={{width: '25%'}}>
                               <TouchableOpacity activeOpacity={0.95}>
                                     <TextInput style={{borderWidth: 0.5, borderColor: '#607D8B', backgroundColor: '#fff', paddingLeft: 4}} value={this.state.toDay}
                                          onChangeText={toDay =>
                                              this.setState({ toDay })
                                          }
                                          ref={input => {
                                              this.textInput = input;
                                          }} />
                               </TouchableOpacity>
                            </View>
                            <View style={{width: '25%', left: 5}}>
                               <TouchableOpacity activeOpacity={0.95}>
                                     <TextInput style={{borderWidth: 0.5, borderColor: '#607D8B', backgroundColor: '#fff', paddingLeft: 4}} value={this.state.fromDay}
                                          onChangeText={fromDay =>
                                              this.setState({ fromDay })
                                          }
                                          ref={input => {
                                              this.textInput = input;
                                          }} />
                               </TouchableOpacity>
                            </View>
                        </View>
                        }
                   </View>

                   <View style={{ width: '100%', paddingTop: 20}}>
                       <Text style={styles.textTitleModal}>Kênh (có thể có nhiều lựa chọn)</Text>
                   </View>

                   <View style={{  }}>
                       <View>
                         {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                            <View
                                  style={{
                                    flexWrap: "wrap",
                                    flexDirection: "row",
                                  }}
                             >
                                {this.loadChannelAPI1()}
                            </View>
                         )}

                       </View>
                   </View>
                   <View style={{ width: '100%', paddingTop: 20}}>
                       <Text style={styles.textTitleModal}>Công ty cơ sở</Text>
                   </View>
                   <View style={{  left: 2}}>

                        {this.state.isLoading ? <ActivityIndicator size = "large"/> : (
                                           <View
                                                 style={{
                                                   flexWrap: "wrap",
                                                   flexDirection: "row",
                                                 }}
                                            >
                                               {this.state.nccAPI.map( item => (
                                                   <SelectMultipleButton
                                                     key={item.idx}
                                                     buttonViewStyle={{
                                                       height: 46,
                                                     }}
                                                     textStyle={{
                                                       fontSize: 12
                                                     }}
                                                     highLightStyle={{
                                                       borderColor: "gray",
                                                       backgroundColor: "transparent",
                                                       borderTintColor: 'gray',
                                                       backgroundTintColor: 'gray',
                                                       textColor: "gray",
                                                       textTintColor: 'gray'
                                                     }}
                                                     value={item.company ? item.company : 'empty'}
                                                     selected={this.state.multipleSelectedDataNCCLimited.includes(
                                                       item.idx
                                                     )}
                                                     singleTap={valueTap =>
                                                       this._singleTapMultipleSelectedButtonsNCC_limited(item.idx)
                                                     }
                                                   />
                                                 ))}
                                           </View>
                                        )}

                                      </View>

                   <View style={{ width: '100%', height: 35, marginTop:10,  alignItems: 'center', justifyContent: 'center'}}>
                       <TouchableHighlight onPress = {this.submitModalSearch.bind(this)}>
                          <Button
                                  onPress = {this.submitModalSearch.bind(this)}
                                   title = "적용"
                                   color = "#c00000"
                                />
                       </TouchableHighlight>
                   </View>

                  </ScrollView>
                </Modal>

                <Modal
                        animationType="slide"
                        transparent={true}
                        visible={this.state.modalVisibleUse}
                        onRequestClose={() => {
                          Alert.alert("Modal has been closed.");
                        }}
                      >
                        <View style={styles.centeredView}>
                          <View style={styles.modalView}>
                            <View style={{position: 'absolute', top: 4, alignItems: 'center', justifyContent: 'center', width: 50, height: 30, right: 20}}>
                                 <TouchableHighlight onPress = {() => {
                                      this.closeModalUse(!this.state.modalVisibleUse)}}>
                                      <Text style = {{alignItems: 'center', justifyContent: 'center', color: '#6d6767ad', fontSize: 22}}>X </Text>
                                 </TouchableHighlight>
                              </View>
                            <Text style={styles.modalText}>경고</Text>
                            <View style={{alignItems: "center"}}>
                                <Text>{this.state.contentWarning}</Text>
                            </View>

                            {this.state.statusNext == 0 &&
                            <View style={{flex: 1, flexDirection: 'row-reverse', position : 'absolute' , bottom: 15, right: 20}}>
                                <TouchableHighlight
                                  style={{ width: 80, height: 30, alignItems: "center", justifyContent: "center", backgroundColor: '#DB4437', borderColor: '#DB4437', borderWidth: 1 }}
                                  onPress={() => {
                                    this.closeModalUse(!this.state.modalVisibleUse);
                                  }}
                                >
                                  <Text style={{color: '#fff'}}>확인</Text>
                                </TouchableHighlight>
                            </View>
                            }
                            {(this.state.statusNext == 1 || this.state.statusNext == 2)  &&
                            <View style={{flex: 1, flexDirection: 'row-reverse', position : 'absolute' , bottom: 15, right: 20}}>
                                <TouchableHighlight
                                  style={{ width: 80, height: 30, alignItems: "center", justifyContent: "center", backgroundColor: '#DB4437', borderColor: '#DB4437', borderWidth: 1 }}
                                  onPress={() => {
                                    this.handUpdateUseRestore();
                                  }}
                                >
                                  <Text style={{color: '#fff'}}>확인</Text>
                                </TouchableHighlight>
                                <TouchableHighlight
                                  style={{left: 10, width: 80, height: 30, alignItems: "center", justifyContent: "center", backgroundColor: '#DB4437', borderColor: '#DB4437', borderWidth: 1 }}
                                 onPress = {() => {this.closeModalUse(!this.state.modalVisibleUse)}}
                                >
                                  <Text style={{color: '#fff'}}>취소</Text>
                                </TouchableHighlight>
                            </View>
                            }
                          </View>
                        </View>
                      </Modal>

            </View>
        );
    }
}

const styles = StyleSheet.create({
   container: { flex: 1, paddingBottom: 140, backgroundColor: '#fff' },
   usageTitle: {
       color: "white",
       marginTop: 20
    },
    horizontalView: {
       width: SCREEN_WIDTH
    },
    contentStyleColor: {
        fontSize: 12,
        color: '#fff'
    },
    contentStyle: {
        fontSize: 12,
    },
    centeredView: {
        flex: 1,
        justifyContent: "center",
        alignItems: "center",
        marginTop: 22
      },
      modalView: {
        width: 350,
        height: 180,
        margin: 20,
        backgroundColor: "white",
        borderRadius: 20,
        padding: 25,
        shadowColor: "#000",
        shadowOffset: {
          width: 0,
          height: 2
        },
        shadowOpacity: 0.25,
        shadowRadius: 3.84,
        elevation: 5
      },
   modalText: {
      marginBottom: 15,
      textAlign: "center",
      color: '#DB4437',
      fontSize: 20,
      fontWeight: 'bold'
    },
   modal: {
     flex: 1,
     alignItems: 'center',
     backgroundColor: '#fefefe',
     padding: 10
   },
   textTitleModal: {
        fontSize: 20
   },
   textModalAll: {
       height: 45,
       alignItems: 'center',
       justifyContent: 'center',
       color: '#c00000',
       backgroundColor: '#fdeada', borderColor: '#c00000', borderWidth: 1, padding: 5, borderRadius: 3,  borderWidth: 1
   },
   textModal: {
      height: 45,
      alignItems: 'center',
      justifyContent: 'center',
      backgroundColor: '#fff', borderColor: '#a9a9a9', borderWidth: 1, padding: 5, borderRadius: 3,  borderWidth: 1
   },
   buttonModalAll: {
        width: '23.5%', height: 60, marginRight: 5
   },
   textbold: {fontWeight: 'bold'},
   textPurcharse: {width: '80%', color: '#fff', backgroundColor: '#3b5998', alignItems: 'center', paddingLeft: 10},
   buttonAllCheckBox: {
         width: 80,
         height: 40,
         alignItems: 'center',
         marginTop: 12,
         borderRadius: 5,
     },
     button: {
          width: 110,
          height: 40,
          backgroundColor: '#DB4437',
          alignItems: 'center',
          marginTop: 12,
          borderRadius: 5
      },
   contentOrder: {borderColor: '#ccc', borderWidth: 1, marginTop: 10, padding: 10 },
   contentOrderLeft: {width: '30%'},
   contentOrderRight: {width: '70%', left: 15 },
   buttonPagination: {
       fontSize: 12,
       backgroundColor: 'rgb(217, 217, 217)',
       marginLeft: 5,
       width: '9%',
       height: 30,
       borderColor: '#000',
       borderWidth: 0.5,
       alignItems: 'center',
       justifyContent: 'center'
   },
   buttonPaginationActive: {
          fontSize: 12,
          backgroundColor: '#DB4437',
          marginLeft: 5,
          width: '9%',
          height: 30,
          borderColor: '#000',
          borderWidth: 0.5,
          alignItems: 'center',
          justifyContent: 'center'
      },
   pagination: {
       backgroundColor: 'rgba(0,0,0,0)',
       width: 400,
       position: 'absolute',
       right: 0,
       left: 0,
       bottom: 7,
       padding: 0,
       flex: 1,
       justifyContent: 'center',
       alignItems: 'center',
       flexDirection: 'row'
    },
    containerMarginTop: {
      marginTop: 30
    },
    footerStyle:
      {
        padding: 7,
        alignItems: 'center',
        justifyContent: 'center',
        borderTopWidth: 2,
        borderColor: '#607D8B'
      },

      TouchableOpacity_style:
      {
        padding: 7,
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#F44336',
        borderRadius: 5,
      },

      TouchableOpacity_Inside_Text:
      {
        textAlign: 'center',
        color: '#fff',
        fontSize: 18
      },

      flatList_items:
      {
        fontSize: 20,
        color: '#000',
        padding: 10
      },
     welcome: {
      margin: 10,
      marginTop: 30,
      color: "gray"
    }

});
/*
 initialNumToRender={50}
                    maxToRenderPerBatch={8}
                    onEndReachedThreshold={4}
*/
//ListFooterComponent = { this.Render_Footer }
//<DataTable style={{backgroundColor: 'rgb(217, 217, 217)'}}>
//                  <DataTable.Pagination
//                    page={this.state.page}
//                    numberOfPages={Math.floor(this.state.totalRow / this.state.perPage)}
//                    onPageChange={page => this.loadMoreOrderAPI(page)}
//                    label={`${this.state.page * this.state.perPage}-${(this.state.page +1) * this.state.perPage} of ${this.state.totalRow}`}
//                  />
//                </DataTable>