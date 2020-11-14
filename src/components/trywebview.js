import React, {Component} from "react";
import {View, Text, StyleSheet, FlatList, ActivityIndicator, TouchableOpacity} from "react-native";
import {List, ListItem, SearchBar} from "react-native-elements";

type Props = {};
export default class Question extends Component<Props> {
    constructor(props) {
        super(props);

        this.state = {
            loading: false,
            data: [],
            page: 1,
            seed: 1,
            error: null,
            refreshing: false
        };
    }

    componentDidMount() {
        this.makeRemoteRequest();
    }

    makeRemoteRequest = () => {
        const {page, seed} = this.state;
        const url = `https://randomuser.me/api/?seed=${seed}&page=${page}&results=20`;
        this.setState({loading: true});

        fetch(url)
            .then(res => res.json())
            .then(res => {
                this.setState({
                    data: page === 1 ? res.results : [...this.state.data, ...res.results],
                    error: res.error || null,
                    loading: false,
                    refreshing: false
                });
            })
            .catch(error => {
                this.setState({error, loading: false});
            });
    };

    handleRefresh = () => {
        this.setState(
            {
                page: 1,
                seed: this.state.seed + 1,
                refreshing: true
            },
            () => {
                this.makeRemoteRequest();
            }
        );
    };

    handleLoadMore = () => {
        this.setState(
            {
                page: this.state.page + 1
            },
            () => {
                this.makeRemoteRequest();
            }
        );
    };

    renderSeparator = () => {
        return (
            <View
                style={{
                    height: 1,
                    width: "86%",
                    backgroundColor: "#CED0CE",
                    marginLeft: "14%"
                }}
            />
        );
    };

    renderHeader = () => {
        return <SearchBar placeholder="Tìm kiếm..." lightTheme round/>;
    };

    renderFooter = () => {
        if (!this.state.loading) return null;

        return (
            <View
                style={{
                    paddingVertical: 20,
                    borderTopWidth: 1,
                    borderColor: "#CED0CE"
                }}
            >
            <TouchableOpacity
                                 activeOpacity = { 0.7 }
                                 style = { styles.TouchableOpacity_style }

                                 >

                                 <Text style = { styles.TouchableOpacity_Inside_Text }>Load More</Text>
                                 <ActivityIndicator animating size="large"/>

                             </TouchableOpacity>

            </View>
        );
    };

    render() {
        return (
            <View>
                <FlatList
                    data={this.state.data}
                    renderItem={({item}) => (
                        <ListItem
                            roundAvatar
                            title={`${item.name.first} ${item.name.last}`}
                            subtitle={item.email}
                            avatar={{uri: item.picture.thumbnail}}
                            containerStyle={{borderBottomWidth: 0}}
                        />
                    )}
                    keyExtractor={item => item.email}
                    ItemSeparatorComponent={this.renderSeparator}
                    ListHeaderComponent={this.renderHeader}
                    ListFooterComponent={this.renderFooter}
                    onRefresh={this.handleRefresh}
                    refreshing={this.state.refreshing}
                    onEndReached={this.handleLoadMore}
                    onEndReachedThreshold={50}
                />
            </View>
        );
    }


}

const styles = StyleSheet.create({
   container: { flex: 1, padding: 10, backgroundColor: '#fff' },
   textbold: {fontWeight: 'bold'},
   textPurcharse: {width: '70%', color: '#fff', backgroundColor: '#3b5998'},
   contentOrder: {borderColor: '#ccc', borderWidth: 1, marginTop: 10, padding: 10 },
   contentOrderLeft: {width: '30%'},
   contentOrderRight: {width: '70%', left: 15 },
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
      }

});


