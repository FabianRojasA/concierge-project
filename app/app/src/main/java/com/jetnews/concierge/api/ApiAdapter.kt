package com.jetnews.concierge.api

import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object ApiAdapter {

    val apiClient: ApiClient = Retrofit.Builder()
            .baseUrl("http://127.0.0.1:8000/api/")
            .client(OkHttpClient())
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ApiClient::class.java)


}