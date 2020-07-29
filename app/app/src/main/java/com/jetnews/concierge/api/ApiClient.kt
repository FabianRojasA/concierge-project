package com.jetnews.concierge.api

import com.jetnews.concierge.api.response.PersonResponse
import retrofit2.Response
import retrofit2.http.GET

interface ApiClient {

    @GET("personas")
    suspend fun getPersonas(): Response<PersonResponse>

}